import Vue from 'vue/dist/vue'
import Vuelidate from 'vuelidate'
import flatPickr from 'vue-flatpickr-component'
import { French } from 'flatpickr/dist/l10n/fr.js';
import { parsePhoneNumberFromString } from 'libphonenumber-js/max'
import { required, minLength, maxLength, email } from 'vuelidate/lib/validators'


export default {
  init() {
    initForm();
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};

function initForm() {
  Vue.use(Vuelidate);

  const form = document.querySelector('#contact')

  new Vue({
    el: '#contact',
    components: {
      flatPickr,
    },
    data: {
      fields: JSON.parse(form.dataset.fields),
      formData: {},
      APIResponse: null,
      message: null,
      pending: false,
      error: false,
      success: false,
      flatPickrConfig: {
          altFormat: 'M j, Y',
          altInput: true,
          locale: French,
      },
    },
    created() {
      this.init()
    },
    /**
     * Validitions rules
     */
    validations() {
      const validations = {formData:{}};

      this.fields.forEach(field => {
        validations.formData[field.name] = {
          ...(field.required && { required }),
          ...(field.minlength && { minLength: minLength(field.minlength) }),
          ...(field.maxlength && { maxLength: maxLength(field.maxlength) }),
          ...(field.min_choice && { minLength: minLength(field.min_choice) }),
          ...(field.max_choice && { maxLength: maxLength(field.max_choice) }),
          ...(field.min && { minDate: minDate(field.min) }),
          ...(field.max && { maxDate: maxDate(field.max) }),
          ...(field.acf_fc_layout === 'email' && { email }),
          ...(field.acf_fc_layout === 'phone' && { phone }),
          ...(field.acf_fc_layout === 'file' && { filesize }),
        }
      });

      return validations
    },
    methods: {
      /**
       * Init reactive data form
       */
      init() {
        this.fields.forEach(field => {
          switch (field.acf_fc_layout) {
            case 'checkbox':
              this.$set(this.formData, field.name, [])
              break;

            default:
              this.$set(this.formData, field.name, '')
              break;
          }
        });
        [...document.querySelectorAll('input[type=file]')].map(el => {el.value = ''});
        [...document.querySelectorAll('.hide-on-load')].map(el => el.classList.remove('hide-on-load'));
      },

      /**
       * Handle file input change
       *
       * @param {MouseEvent} e
       */
      fileInputOnChange(e) {
        this.$set(this.formData, e.target.name, e.target.files[0])
      },

      /**
       * Handle form submit
       *
       * @param {MouseEvent} e
       */
      async onSubmit(e) {
        e.preventDefault();

        if (this.pending) return
        if (this.APIResponse) this.APIResponse = null
        if (this.message) this.message = null
        this.error = false
        this.success = false
        if (this.$v.formData.$invalid) {
          this.error = true
          return
        }

        this.pending = true

        const token = await getRecaptchaToken();
        if (!token) {
          this.error = true
          this.pending = false
          return
        }

        const formData = new FormData(this.$refs.form);
        formData.append('captcha-token', token)

        const response = await fetch(`/wp-json/contact/v1/contact/${form.dataset.id}`, {
          method: 'POST',
          body: formData,
        })
        this.APIResponse = await response.json()
        this.pending = false
        this.message = this.APIResponse.message

        if (response.status !== 200) {
          this.error = true
          return
        }

        this.success = true
        this.init()
      },
    },
  })
}

/**
 * Validation rule for phone number
 *
 * @param {string} value
 * @returns {boolean}
 */
function phone(value) {
  const phoneNumber = parsePhoneNumberFromString(value.trim());

  if (phoneNumber) return phoneNumber.isValid()

  return value.trim() !== '' ? false : true;
}

/**
 * Validation rule for minimum Date Choice
 *
 * @param {string} min yyyy-mm-dd
 * @returns {boolean}
 */
function minDate(min) {
  return (value) => {
    const selectedDates = value.match(/\d{4}-\d{2}-\d{2}/g)

    if(selectedDates && selectedDates.length > 1) {
      return Date.parse(selectedDates[0]) >= Date.parse(min)
    }

    return Date.parse(value) >= Date.parse(min)
  }
}

/**
 * Validation rule for maximum Date Choice
 *
 * @param {string} max yyyy-mm-dd
 * @returns {boolean}
 */
function maxDate(max) {
  return (value) => {
    const selectedDates = value.match(/\d{4}-\d{2}-\d{2}/g)

    if(selectedDates && selectedDates.length > 1) {
      return Date.parse(selectedDates[1]) <= Date.parse(max)
    }

    return Date.parse(value) <= Date.parse(max)
  }
}

/**
 * Validation rule for filesize
 *
 * @param {string} max yyyy-mm-dd
 * @returns {boolean}
 */
function filesize(value) {
  if(!value){
    return true;
  }

  return value.size < 5000000
}

/**
 * Retrieve the recaptcha token
 */
async function getRecaptchaToken() {
  return await new Promise((resolve, reject) => {
    grecaptcha.ready(async function() {
      try {
        const token = await grecaptcha.execute(process.env.RECAPTCHA_PUBLIC_KEY, {action: 'contact'})
        return resolve(token)
      } catch (error) {
        return reject(error)
      }
    });
  })
}
