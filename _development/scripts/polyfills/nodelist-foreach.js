// document.querySelectorAll returns a NodeList.
// IE doesn't support forEach method for NodeList.
const nodeListForEachPolyfill = () => {
    if ( window.NodeList && ! NodeList.prototype.forEach ) {
        NodeList.prototype.forEach = function ( callback, thisArg ) {
            thisArg = thisArg || window;
            for (let i = 0; i < this.length; i++) {
                callback.call( thisArg, this[i], i, this );
            }
        };
    }
}

export default nodeListForEachPolyfill;
