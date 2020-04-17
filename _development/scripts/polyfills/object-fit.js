/**
 * Provides a background image fallback when browser doesn't support an 'object-fit' property.
 *
 * @param { string || array } targetClass: all class names where polyfill should be applied.
 * @param { string } fallbackClass: a class that will be added when object-fit polyfill is used
 */
export default function objectFit({
    targetClass = 'img-fit',
    fallbackClass = 'img-fit--fallback'
} = {}) {

    // do nothing if browser supports 'object-fit'.
    if ( objectFitIsSupported() ) {
        return;
    }

    if ( Array.isArray( targetClass )) {
        targetClass = targetClass.join( ',.' );
    }

    const targets = document.querySelectorAll( `.${ targetClass }` );

    if ( targets ) {
        targets.forEach( target => provideFallback( target, fallbackClass ) );
    }
}

const objectFitIsSupported = () => 'objectFit' in document.documentElement.style;

// Applies background-image to image container and removes the image from DOM
const provideFallback = ( imageContainer, fallbackClass ) => {
    const   image = imageContainer.querySelector( 'img' );
    let     imageUrl = image.getAttribute( 'src' );
    const   imageDataUrl = image.getAttribute( 'data-src' );

    if(imageDataUrl !== null && imageDataUrl !== ""){
        imageUrl = imageDataUrl;
    }

    if ( ! imageUrl ) {
        return;
    }

    imageContainer.classList.add( fallbackClass );
    imageContainer.style.backgroundImage = `url( ${ imageUrl } )`;
    image.parentNode.removeChild( image );
}
