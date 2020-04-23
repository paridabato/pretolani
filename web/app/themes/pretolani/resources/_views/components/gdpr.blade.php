<div class="gdpr" data-hash="{{ $gdpr['id'] }}" @if($gdpr['isByPass']) data-by-pass @endif>
  <div class="gdpr-bar @if ($gdpr['constants']['bar']['cube']) cube @else bar @endif">
    <div class="gdpr-bar__notice">
      <p>{{ __( $gdpr['constants']['bar']['explanation'], '148-gdpr') }}</p>
    </div>
    <button class="gdpr-bar__button--modal">{{ __( $gdpr['constants']['bar']['buttons'][0], '148-gdpr') }}</button>
    <button class="gdpr-bar__button--agree">{{ __( $gdpr['constants']['bar']['buttons'][1], '148-gdpr') }}</button>
  </div>

  <div class="gdpr-modal">
    <div class="gdpr-modal__container">
      <nav class="gdpr-modal__navigation">
        <p class="gdpr-modal__button active" data-target="params">{{ __( $gdpr['constants']['modal']['title'], '148-gdpr') }}</p>
        @foreach ($gdpr['consents'] as $key => $consent)
          <p class="gdpr-modal__button" data-target="{{ $key }}">{{ __( $consent['title'], '148-gdpr') }}</p>
        @endforeach
      </nav>
      <div class="gdpr-modal__information">
        <div class="gdpr-modal__description active" data-target="params">
          <p class="gdpr-modal__title">{{ __( $gdpr['constants']['modal']['title'], '148-gdpr')}}</p>
          <div class="gdpr-modal__content">
            {{ __( $gdpr['constants']['modal']['description'], '148-gdpr') }}
            <a href="{{ get_privacy_policy_url() }}" class="gdpr-modal__privacy">{{ __( $gdpr['constants']['modal']['privacy_text'], '148-gdpr') }}</a>
          </div>
        </div>
        @foreach ($gdpr['consents'] as $key => $consent)
          <div class="gdpr-modal__description" data-target="{{ $key }}">
            <p class="gdpr-modal__title">{{ __( $consent['title'], '148-gdpr') }}</p>
            <div class="gdpr-modal__content">{{ __( $consent['description'], '148-gdpr') }}</div>
              <div class="gdpr-modal__switch r @if ($consent['required']) hidden @endif">
                <input type="checkbox" name="{{ $key }}" class="checkbox gdpr-input @if ($consent['required'])required @endif" @if (!$consent['opout'] && !$consent['required']) checked @endif>
                <div class="knobs"></div>
                <div class="layer"></div>
              </div>
          </div>
        @endforeach
        <div class="gdpr-modal__footer">
          <button class="gdpr-modal__footer--button gdpr-modal__footer--button--agree">{{ __( $gdpr['constants']['modal']['buttons'][0], '148-gdpr') }}</button>
          <button class="gdpr-modal__footer--button gdpr-modal__footer--button--disagree">{{ __( $gdpr['constants']['modal']['buttons'][1], '148-gdpr') }}</button>
        </div>
      </div>
      <button class="gdpr-modal__close">✕</button>
    </div>
  </div>
</div>
