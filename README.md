# ajax-framework
Example of search engine friendly ajax loaded pages with complete fallback for older browsers.

.editorconfig not needed. I just like to include it to make sure my editor knows how I like my code to be formatted.

Give any link you want to be ajax-loaded the class name "hijax". 
This is the class we look for in the function "connectHijaxLoading" that handle the hijacking of the links and
replace them with ajax loading goodness.

I've not included this functionality in the example, but if you have links on your other pages that you'd like
to include as ajax loaded content, create a function called "updateUI". You can see this function being referenced
as a callback from ajaxLoader(). The function will be executed when the ajaxloading is done. At the very least it
would be required to add "connectHijaxLoading()" so that it can look for new links. I also put stuff like scrolling
to the top of the page and fading in the content in the updateUI function.

Please remember to upload the .htaccess file after editing it and changing my domain name with yours.
To see this very example in action, have a look at my portfolio which is what I wrote it for in the first place:
http://www.delin.uk

Enjoy.
