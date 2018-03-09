# Post Reading Progress

## Description

Wordpress plugin - articles reading progress bar.

This plugin allows to display **reading progress** of single article using horizontal progress bar. You can customize following plugin options:

* define which **post types** should be supported
* **top**, **right**, **bottom** an **left** position display
* setting progress bar height
* hiding progress bar after reading complete
* two autohide bar animations (slide, fade out)
* setting background and foreground progress bar color

## Usage

After downloading repo you have to build all assets using:
```
npm run build:prod
```

Then you can upload plugin into **wp-content -> plugins** directory and activate it via wp-admin panel.
 
All customizable options are available under **settings -> readings** section.

## Screenshots

### Example of usage:
![Frontend image](https://raw.githubusercontent.com/xmd5a/wordpress-reading-progress/master/docs/screenshot-2.png)

### Admin panel options:
![Admin panel image](https://raw.githubusercontent.com/xmd5a/wordpress-reading-progress/master/docs/screenshot-1.png)

