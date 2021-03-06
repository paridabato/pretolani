import gdpr from '../components/gdpr';
import sign148 from '../util/148';
import lazyload from '../util/lazyload'

export default {
  init() {
    // JavaScript to be fired on all pages
    gdpr();
    sign148.init();
    lazyload();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired

  },
};
