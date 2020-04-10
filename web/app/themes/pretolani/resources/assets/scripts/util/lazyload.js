/* eslint-disable */

export default () => {
  // select both source and image elements
  const images = window.document.querySelectorAll('[data-src], [data-srcset]');

  // Some config parameters for the IntersectionObserve
  const config = {
    // If the image gets within 50px in the Y axis, start the download.
    rootMargin: '50px 0px',
    threshold: 0.01
  };

  let observer;

  // If we don't have support for intersection observer, load the images immediately
  if (!('IntersectionObserver' in window)) {
    Array.from(images).forEach(image => preloadImage(image));
  }
  else {
    // It is supported, load the images by calling our method: onIntersection
    observer = new IntersectionObserver(onIntersection, config);
    images.forEach(image => observer.observe(image));
  }

  // Replace the data-src attribute with the value of the data-src attribute
  function preloadImage(element) {
    if(element.dataset && element.dataset.src) {
      element.src = element.dataset.src;
      delete element.dataset.src;
    }

    if(element.dataset && element.dataset.srcset) {
      element.srcset = element.dataset.srcset;
      delete element.dataset.srcset;
    }
  }

  function onIntersection(entries) {
    entries.forEach(entry => {
      if (entry.intersectionRatio > 0) {
        // Stop watching and load the image
        observer.unobserve(entry.target);
        // call our method: preloadImage
        preloadImage(entry.target);
      }
    });
  }
}
