4.0
===

Breaking changes:

- The library now uses container-interop/service-provider to set up the container. It is therefore framework agnostic
- Automatic registration of "component" packages has been removed.
- PHP 7.1 is now required
- Remvoing `getFeatures` from WebLbiraryInterface as this has never been implemented in practice.

3.0
===

- Removed the WebLibraryRenderers. We now use Mouf's standard rendering system
- Added support for `addJsFile` and `addCssFile` in `WebLibraryManager`.
 