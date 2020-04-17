'use strict';

import config from '../_development/config/config';
import fs from 'fs';
import dirTree from 'directory-tree';

export default function manifest(cb){
    const nodes = dirTree(config.paths.base.dest);
    let mytree = crawlTree(nodes);

    fs.writeFile(
        config.paths.base.dest + config.paths.manifest, // File to write to
        JSON.stringify(mytree), // Contents of file
        {}, // Options for the file
        function (err) { // Callback
            if (err) {
                throw err;
            }
        }
    );

    cb();
}

function crawlTree(node, path = '') {
    if(node.type === 'directory'){
        let tree = {};

        for(let childNode of node.children) {
            let key = stripChunk(childNode.name);

            tree[key] = crawlTree(childNode, path + '/' + node.name);
        }

        return tree;
    }

    return (path + '/' + node.name).replace('/assets/', '');
}

function stripChunk(name)
{
    if(name.includes('.css') || name.includes('.js') || name.includes('.mjs')) {
        let parts = name.split('.');

        if(parts.length > 2) {
            parts.splice(parts.length - 2, 1);
            return parts.join('.');
        }
    }

    return name;
}
