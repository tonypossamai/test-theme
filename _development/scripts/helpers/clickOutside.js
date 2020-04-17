// Use with a click listener on the document. Returns true if the click is outside the element you pass in.
export default function clickOutside(event, element) {
        let clickedElement = event.target; // clicked element

        do {
            if (clickedElement == element) {
                // This is a click inside. Do nothing, just return.
                return false;
            }
            // Go up the DOM
            clickedElement = clickedElement.parentNode;
        } while (clickedElement);

        return true;
}
