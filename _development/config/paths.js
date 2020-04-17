export default {
    "base": {
        "src": "./_development/",
        "dest": "assets/"
    },
    "manifest": "manifest.json",
    "scripts": {
        "src": "scripts/",
        "dest": "scripts/",
        "entry": "*.js"
    },
    "styles": {
        "src": "styles/",
        "dest": "styles/",
        "entry": "*.scss",
    },
    "fonts": {
        "src": "fonts/",
        "dest": "fonts/",
        "entry": "**/*"
    },
    "general": {
        "src": "general/",
        "dest": "general/",
        "entry": "**/*"
    },
    "images": {
        "src": "images/",
        "dest": "images/",
        "entry": "**/*"
    },
    "svg": {
        "src": "images/",
        "dest": "svgs/",
        "entry": "**/*.svg"
    },
    "components": {
        "src": "components/",
        "dest": "components/",
        "entry": "[^_]"
    },
    "php": [
        "*.php",
        "**/*.php",
        "!vendor/**/*.*",
        "!node_modules/**/*.*",
    ],
    "includePaths": [
        'node_modules/',
    ]
}
