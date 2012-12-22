**Special note**
This experiment branch is not ready for use on live site. ZePLUF was first built when no one in our team has deep knowledge of Symfony2 yet, and in this experiment version we will try to standardize our code.
- We will now change our structure to a more Symfony2-like one. We will place site specific code in app/, and others in src/ and vendor/. This will allow us to have more than 1 site using the same base code. The goal is to eventually move the whole Zencart into vendor/ as well.
- We will now also start using more Symfony2 Components and Bundles, and to test our code for better performance and add more logging debug tools.
- Our goal is not to replace Zencart but to supplement it, so we will try to make sure this framework can be put on top of any existing Zencart store without breaking anything.

In the process we are also borrowing some ideas from ZenMagick project https://github.com/ZenMagick/ZenMagick. Though our goals are different, we are taking similar approach and the guys there are really smart guys with great ideas.

The Zencart Plugin Framework (ZePLUF) is a product of rubikin.com

This framework is meant to be used with Zencart version 1.3.9h and above

**Features**
- Allows developers to package their plugin(s) in one single place (in most cases) instead of spreading the files all over the place.
- Installing/Uninstalling a Zencart plugin has never been easier, in many cases it's just a matter of uploading the new plugin folder. No more messing around with various Zencart folders.
- Files/Classes are loaded on demand with PHP 5.3 lazy load feature.
- Allows developers to save time while developing their modules by making use of the framework's useful features (such at the ability to inject content into any location)
- Many of our modules also rely on ZePLUF to work, you won't be able to use our modules without ZePLUF

**Documentation**

http://rubikin.com/wiki/zencart/plugin_framework/about