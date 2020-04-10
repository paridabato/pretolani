import { getCookie, setCookie, delCookie } from '../util/cookies';

let cookieName = 'gdpr-148'

function init() {
  if (check()) {
    const gdprContainer = document.querySelector('.gdpr')
    const gdprBar = gdprContainer.querySelector('.gdpr-bar')
    const gdprBarModalOpen = gdprBar.querySelector('.gdpr-bar__button--modal')
    const gdprBarAgreeButton = gdprBar.querySelector('.gdpr-bar__button--agree')

    const gdprModal = gdprContainer.querySelector('.gdpr-modal')
    const gdprModalButtons = gdprModal.querySelectorAll('.gdpr-modal__button')
    const gdprBarModalClose = gdprModal.querySelector('.gdpr-modal__close')
    const gdprModalAgreeButton = gdprModal.querySelector('.gdpr-modal__footer--button--agree')
    const gdprModalDisagreeButton = gdprModal.querySelector('.gdpr-modal__footer--button--disagree')

    if (gdprContainer.hasAttribute('data-by-pass')) {
      agree();
      return
    }

    gdprContainer.classList.add('active')
    setTimeout(() => gdprBar.classList.add('show'), 500);

    const showModal = () => gdprModal.classList.add('show')
    const hideModal = () => gdprModal.classList.remove('show')
    const showDescription = el => {
      const button = el.target
      const target = button.dataset.target
      const buttonActive = gdprModal.querySelector('.gdpr-modal__button.active')
      const containerActive = gdprModal.querySelector('.gdpr-modal__description.active')
      const container = gdprModal.querySelector(`.gdpr-modal__description[data-target="${target}"]`)

      buttonActive.classList.remove('active')
      containerActive.classList.remove('active')
      button.classList.add('active')
      container.classList.add('active')
    }

    bind()

    function activeCookie(agree = true) {
      const inputs = agree ? document.querySelectorAll('.gdpr-input') : document.querySelectorAll('.gdpr-input.required')
      const cookie = {
        id: document.querySelector('.gdpr').dataset.hash,
        consents: [],
      }

      inputs.forEach(input => (!input.checked) ? cookie.consents.push(input.name) : null)

      setCookie(cookieName, JSON.stringify(cookie))
      fireCode(cookie.consents)

      gdprModal.classList.remove('show')
      gdprBar.classList.remove('show')
      gdprContainer.classList.remove('active')

      unbind()
    }

    function bind() {
      gdprBarModalOpen.addEventListener('click', showModal)
      gdprBarModalClose.addEventListener('click', hideModal)
      gdprModalButtons.forEach(button => button.addEventListener('click', showDescription))
      gdprBarAgreeButton.addEventListener('click', activeCookie)
      gdprModalAgreeButton.addEventListener('click', activeCookie)
      gdprModalAgreeButton.addEventListener('click', activeCookie)
      gdprModalDisagreeButton.addEventListener('click', () => activeCookie(false))
    }

    function unbind() {
      gdprBarModalOpen.removeEventListener('click', showModal)
      gdprBarModalClose.removeEventListener('click', hideModal)
      gdprModalButtons.forEach(button => button.removeEventListener('click', showDescription))
      gdprBarAgreeButton.removeEventListener('click', activeCookie)
      gdprModalAgreeButton.removeEventListener('click', activeCookie)
      gdprModalDisagreeButton.removeEventListener('click', () => activeCookie(false))
    }
  }
}

function check() {
  let cookie = getCookie(cookieName)
  let url = new URL(location.href);
  let isParamsUrl = url.searchParams.has('gdpr');

  if (isParamsUrl) return true

  if (cookie) {
    const id = document.querySelector('.gdpr').dataset.hash
    cookie = JSON.parse(cookie)

    if (cookie.id === id) {
      fireCode(cookie.consents)
      return false
    }
  }

  return true
}

function fireCode(list = null) {
  if (list !== null) {
    list.forEach(id => {
      let s = document.getElementById(`gdpr-${id}`)
      s.src = s.dataset.src
      s.dataset.src = ''
    })
  }
}

export default init
