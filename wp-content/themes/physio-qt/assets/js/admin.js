jQuery(document).ready( function($) {
    'use strict';

    // Cusotm Media File Uploader
    var file_frame;
    var attachment;
    $(document).on('click', '.qt-upload-file-button', function(){

        var clicked = $(this);

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Choose a File',
            button: { text: 'Select File' },
            multiple: false
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {

        // Get the url of the selected object and add to the input field
        attachment = file_frame.state().get( 'selection' ).first().toJSON();
            clicked.closest( 'p' ).find( '.upload-file-url' ).val( attachment.url );
        });

        // Open the modal
        file_frame.open();
    });

    // Color picker for the CTA Banner Widget
    $( '.qt-color-picker' ).wpColorPicker();
    
    // Color picker for if widget is saved
    $(document).ajaxComplete(function() {
        $( '.qt-color-picker' ).wpColorPicker();
    });

});

/* 
 * Backbone repeating fields for Testimonial Widget
 */
var QTTestimonials = QTTestimonials || {};

// Model for a single testimonial
QTTestimonials.Testimonial = Backbone.Model.extend({
    defaults: { 
        'quote':  '',
        'author': '',
        'description': '',
    },
});

// Single view, responsible for rendering and manipulation of each single testimonial
QTTestimonials.TestimonialView = Backbone.View.extend( {

    className: 'testimonial-widget-child',

    events: {
        'click .js-remove-testimonial': 'destroy'
    },

    initialize: function ( params ) {

        this.template = params.template;
        this.model.on( 'change', this.render, this );

        return this;
    },

    render: function () {

        this.$el.html( this.template( this.model.attributes ) );

        return this;
    },

    destroy: function ( ev ) {

        ev.preventDefault();

        this.remove();
        this.model.trigger( 'destroy' );
    },

} );
 
// The list view, responsible for manipulating the array of testimonials
QTTestimonials.TestimonialsView = Backbone.View.extend( {
 
    events: {
        'click #js-testimonials-add': 'addNew'
    },

    initialize: function ( params ) {

        this.widgetId = params.id;

        // cached reference to the element in the DOM
        this.$testimonials = this.$( '#js-testimonials-list' );

        // collection of testimonials, local to each instance of QTTestimonials.testimonialsView
        this.testimonials = new Backbone.Collection( [], {
            model: QTTestimonials.Testimonial
        } );

    // listen to adding of the new testimonials
    this.listenTo( this.testimonials, 'add', this.appendOne );

    return this;
    },

    addNew: function ( ev ) {

    ev.preventDefault();

    // default, if there is no testimonials added yet
    var testimonialId = 0;

    if ( ! this.testimonials.isEmpty() ) {
        var testimonialsWithMaxId = this.testimonials.max( function ( testimonial ) {
            return testimonial.id;
         } );

        testimonialId = parseInt( testimonialsWithMaxId.id, 10 ) + 1;
    }

    var model = QTTestimonials.Testimonial;

    this.testimonials.add( new model( { id: testimonialId } ) );

    return this;
    },

    appendOne: function ( testimonial ) {

    var renderedTestimonial = new QTTestimonials.TestimonialView( {
        model:    testimonial,
        template: _.template( jQuery( '#js-testimonial-' + this.widgetId ).html() ),
    } ).render();

    this.$testimonials.append( renderedTestimonial.el );

    return this;
    }
 
} );
 
 
QTTestimonials.repopulateTestimonials = function ( id, JSON ) {
 
    var testimonialsView = new QTTestimonials.TestimonialsView( {
        id: id,
        el: '#js-testimonials-' + id,
    } );

    testimonialsView.testimonials.add( JSON );
};