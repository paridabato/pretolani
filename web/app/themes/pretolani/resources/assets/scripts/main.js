import '@babel/polyfill';
import camelCase from './util/camelCase';
import Bowser from 'bowser';
import { listen } from 'quicklink';

// import Array of all Routes we want
import routes from './routes';

// Fire up service worker
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/app/themes/pretolani/dist/sw.js')
    // .then(registration => {
    //   console.log('SW registered: ', registration);
    // })
    .catch(registrationError => {
      console.log('SW registration failed: ', registrationError);
    });
  });
} else {
  console.log('Service worker is not active on your navigator');
}

// Wait page is loaded
window.onload = async () => {

  // Init QuickLink
  listen();

  // Check Browser and import good polyfill
  const browser = Bowser.getParser(window.navigator.userAgent);
  const browserName = browser.getBrowserName().toLowerCase().replace(' ', '_');

  await import(/* webpackChunkName: "polyfill", webpackPreload: true */ `./polyfills/${browserName}`);

  // import common.js for all page
  const { default: common } = await import(/* webpackChunkName: "common", webpackPreload: true */ './routes/common');

  // Fire Init for common.js
  common.init();

  // Check class on body to determine the current page
  document.body.className
  .toLowerCase()
  .replace(/-/g, '_')
  .split(/\s+/)
  .map(camelCase)
  .forEach(async (className) => {

    if (routes.includes(className)) {

      // Import right .js for the current page
      const { default: _ } = await import(/* webpackChunkName: "[request]", webpackPrefetch: true */ `./routes/${className}`);

      // Fire init & finalize from current page .js
      _.init();
      _.finalize();
    }

    // Fire common.js
  });

  common.finalize()
}
