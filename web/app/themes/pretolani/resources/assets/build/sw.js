importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.0.0/workbox-sw.js');

if (workbox) {
  const cacheNameDetails = {
    prefix: self.location.hostname,
    suffix: '',
    precache: 'precache',
  }

  workbox.core.setCacheNameDetails(cacheNameDetails)

  /**
   * Register route for assets-cache
   * Add in cache all assets
   * Exclude :
   * - /wp/
   * - /app/
   * */
  workbox.routing.registerRoute(
    /^(https?:\/\/[^\/]+?)?\/(?!(wp|app|recaptcha)\/).*\.(css|js)(\?.*)?$/,
    new workbox.strategies.StaleWhileRevalidate({
      cacheName: `${self.location.hostname}-assets-cache`,
    })
  );

  /**
   * Register route for images-cache
   * Add in cache all images
   * Exclude :
   * - /wp/
   * - /app/themes/{project_name}/dist/images/
   * */
  workbox.routing.registerRoute(
    /^(https?:\/\/[^\/]+?)?\/(?!(wp|.*\/dist\/images)\/).*\.(jpe?g|gif|png|webp|svg)$/,
    new workbox.strategies.StaleWhileRevalidate({
      cacheName: `${self.location.hostname}-images-cache`,
    })
  );

  /**
   * Register route for quicklink-cache
   * Add in cache all internal links
   * Exclude :
   * - /wp/
   * - /app/
   * - assets
   * - images
   * */
  workbox.routing.registerRoute(
    new RegExp(`^${self.location.origin}(\/(?!(wp|wp-json|app)\/)(?!.+\.(css|js|jpe?g|gif|png|webp|svg)).*)?$`),
    new workbox.strategies.StaleWhileRevalidate({
      cacheName: `${self.location.hostname}-quicklink-cache`,
    })
  );

  // Check if SW updated is found
  self.registration.addEventListener('updatefound', () => {
    // New Update Found (Call the first time too)
    const sw = self.registration.installing;

    // Service Worker state change
    sw.addEventListener('statechange', () => {
      // Service Worker installed (waiting)
      if (sw.state === 'installed') {
        // New SW installed, so skip waiting
        self.skipWaiting();
      }
    })
  })

  // Service Worker installing
  self.addEventListener('install', (event) => {
    // Do some stuff
  })

  // Service Worker receive message (push or sync)
  self.addEventListener('message', (event) => {
    // Do some stuff
  })

  // Service Worker activated (active)
  self.addEventListener('activate', (event) => {
    // Remove registered cache (assets-cache & images-cache) due updated Service Worker
    event.waitUntil(
      caches.keys().then(cacheNames => {
        if (cacheNames.length > 0) {
          cacheNames.forEach(cacheName => {
            if (cacheName.includes(`${self.location.hostname}-`) && cacheName !== `${self.location.hostname}-precache`) {
              caches.delete(cacheName);
            }
          })
        }
      })
    )
  })

  // TODO: Resolve CORS problem
  /**
   * Precache all project files (dist/)
   * Example :
   * - dist/scripts/common_[hash].js
   * - dist/styles/common_[hash].css
   * - dist/fonts/
   * - dist/images/
   * */
  workbox.precaching.precacheAndRoute(self.__WB_MANIFEST);

  /**
   * Enable Google Analytics Offline
   * Only register Google Analytics URL
   */
  workbox.googleAnalytics.initialize();
}
