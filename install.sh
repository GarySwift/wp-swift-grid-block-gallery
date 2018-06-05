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
mv page-gallery.php $theme_path"/page-templates/page-gallery.php"
mv magnific-popup.js $theme_path"/src/assets/js/lib/magnific-popup.js"
mv _gallery.scss $theme_path"/src/assets/scss/_gallery.scss"

printf "Do wish to install magnific-popup using npm? [y/N] "
read verfiy
# Check result
if [[ $verfiy =~ ^[Yy]$ ]]
then
	cd $theme_path
	echo "npm install magnific-popup --save"
	npm install magnific-popup --save
	echo "import '../../../node_modules/magnific-popup/dist/jquery.magnific-popup.min';" >> $theme_path"/src/assets/js/app.js"
	echo "import './lib/magnific-popup';" >> $theme_path"/src/assets/js/app.js"
	subl $theme_path"/src/assets/js/app.js"
	echo "@import '../../../node_modules/magnific-popup/dist/magnific-popup';" >> $theme_path"/src/assets/scss/app.scss"
fi
echo "@import 'gallery';" >> $theme_path"/src/assets/scss/app.scss"
subl $theme_path"/src/assets/scss/app.scss"
