#!/bin/bash
clear
echo "ls -1 ../../themes"
ls -1 ../../themes
printf 'Enter your WordPress theme name: '
read theme
theme_path="../../themes/"$theme
if [ ! -d $theme_path ]
then
	echo "Theme does not exist!"  
	echo "Aborted"
	exit
fi

cp page-gallery.php $theme_path"/page-templates/page-gallery.php"
cp magnific-popup.js $theme_path"/src/assets/js/lib/magnific-popup.js"


printf "Do wish to install magnific-popup using npm? [y/N] "
read verfiy
# Check result
if [[ $verfiy =~ ^[Yy]$ ]]
then
	cd $theme_path
	echo "npm install magnific-popup --save"
	npm install magnific-popup --save
	echo
	echo "Please add the following imports to src/assets/js/app.js"
	echo "import '../../../node_modules/magnific-popup/dist/jquery.magnific-popup.min';"
	echo "import './lib/magnific-popup';"
	echo
	echo "Please add the following imports to src/assets/scss/app.scss"
	echo "@import '../../../node_modules/magnific-popup/dist/magnific-popup';"
	echo
fi

