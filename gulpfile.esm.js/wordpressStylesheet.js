'use strict';

import config from '../_development/config/config';
import { writeFile } from 'fs';

export default function wordpressStylesheet(cb) {
    const newline = '\r\n'; // New line code

    // Add a timestamp to the wordpress information
    config.wordpress['Version'] = Math.floor(Date.now() / 1000);

    let content = '/*' + newline; // Open the comments

    // Loop through each of the wordpress keys and add them to the string
    for(let index in config.wordpress) {
       if (config.wordpress.hasOwnProperty(index)) {
           content += index + ": " + config.wordpress[index] + newline;
       }
    }

    content += "*/"; // Close the comments

    writeFile(
        './style.css', // File to write to
        content, // Contents of file
        {}, // Options for the file
        function(err) { // Callback
            if(err) {
                throw err;
            }
        }
    );

    cb();
};
