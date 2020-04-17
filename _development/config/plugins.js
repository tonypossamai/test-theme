export default {
    "stylelint": {
        "failAfterError": false,
        "reporters": [
            {
                "formatter": "string",
                "console": true
            }
        ],
    },
    "imagemin": {
        "gif": {
            "interlaced": true,
            "optimizationLevel": 3
        },
        "jpg": {
            "quality": 80,
            "progressive": true
        },
        "png": {
            "optimizationLevel": 7,
        },
        "svg": {
            "plugins": [
                { "cleanupAttrs": true },
                { "cleanupIDs": false },
                { "removeComments": true },
                { "removeEmptyAtts": true },
                { "removeEmptyContainers": true },
                { "removeEmptyText": true },
                { "removeUnusedNS": true },
                { "removeUselessDefs": true },
                { "removeViewBox": false },
            ]
        },
        "svgdeep": {
            "plugins": [
                { "cleanupAttrs": true },
                { "cleanupIDs": true },
                { "removeComments": true },
                { "removeDimensions": true },
                { "removeDesc": true },
                { "removeEmptyAtts": true },
                { "removeEmptyContainers": true },
                { "removeEmptyText": true },
                { "removeMetadata": true },
                { "removeTitle": true },
                { "removeUnusedNS": true },
                { "removeUselessDefs": true },
                { "removeViewBox": false },
            ]
        }
    }
}
