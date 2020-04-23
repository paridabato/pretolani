{{--
Template Name: Contact Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
<div id="contact" data-fields='@json($form_object)' data-id="{{ the_ID() }}">
      <form id="contactForm" ref="form" v-on:submit="onSubmit">
        @if(count($form_object))
        @foreach ($form_object as $k => $v)
          <div>
            <div>
              @if($v['acf_fc_layout'] !== "checkbox")
              <label for="{{ $v['name'] }}">{{ $v['label'] }}</label>
              @endif

              @switch($v['acf_fc_layout'])
                @case("select")
                  @if(count($v['options']))
                    <select
                      name="{{ $v['name'] }}"
                      id="{{ $v['name'] }}"
                      v-model="formData.{{ $v['name'] }}">
                      @foreach ($v['options'] as $item)
                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                      @endforeach
                    </select>
                  @endif
                  @break

                @case("checkbox")
                  @if(count($v['checkboxes']))
                    <p>{{ $v['label'] }}</p>

                    @foreach ($v['checkboxes'] as $checkbox)
                      <label for="{{ $checkbox['value'] }}">{{ $checkbox['label'] }}</label>
                      <input
                        type="checkbox"
                        name="{{ $v['name'] }}[]"
                        id="{{ $checkbox['value'] }}"
                        value="{{ $checkbox['value'] }}"
                        v-model="formData.{{ $v['name'] }}"
                        @if(isset($v['max_choice']) && $v['max_choice']) data-maxChoice="{{$v['max_choice']}}" @endif
                        @if(isset($v['min_choice']) && $v['min_choice']) data-minChoice="{{$v['min_choice']}}" @endif>
                    @endforeach
                  @endif
                  @break

                @case("textarea")
                  <textarea
                    id="{{ $v['name'] }}"
                    name="{{ $v['name'] }}"
                    v-model="formData.{{ $v['name'] }}"
                    @if(isset($v['placeholder']) && $v['placeholder']) placeholder="{{ $v['placeholder'] }}" @endif
                    @if(isset($v['maxlength']) && $v['maxlength']) maxlength={{ $v['maxlength'] }} @endif
                    @if(isset($v['minlength']) && $v['minlength']) minlength={{ $v['minlength'] }} @endif
                    @if(isset($v['required']) && $v['required']) required @endif></textarea>
                  @break

                @case("date")
                  <flat-pickr
                    v-model="formData.{{ $v['name'] }}"
                    name="{{ $v['name'] }}"
                    id="{{ $v['name'] }}"
                    v-bind:config="{...flatPickrConfig,
                      @if(isset($v['range']) && $v['range'])
                        mode: 'range',
                      @endif
                      @if(isset($v['min']) && $v['min'])
                        minDate: '{{$v['min']}}',
                      @endif
                      @if(isset($v['max']) && $v['max'])
                        maxDate: '{{$v['max']}}',
                      @endif
                    }"
                    @if(isset($v['placeholder']) && $v['placeholder']) placeholder="{{ $v['placeholder'] }}" @endif
                    />
                  @break

                @case("file")
                  <input
                  type="{{ $v['acf_fc_layout'] }}"
                  id="{{ $v['name'] }}"
                  name="{{ $v['name'] }}"
                  v-on:change="fileInputOnChange"
                  @if(isset($v['placeholder']) && $v['placeholder']) placeholder="{{ $v['placeholder'] }}" @endif
                  @if(isset($v['required']) && $v['required']) required @endif
                  accept="image/*,.pdf">
                  @break

                @default
                  <input
                    type="{{ $v['acf_fc_layout'] }}"
                    id="{{ $v['name'] }}"
                    name="{{ $v['name'] }}"
                    v-model="formData.{{ $v['name'] }}"
                    @if(isset($v['placeholder']) && $v['placeholder']) placeholder="{{ $v['placeholder'] }}" @endif
                    @if(isset($v['maxlength']) && $v['maxlength']) maxlength="{{ $v['maxlength'] }}" @endif
                    @if(isset($v['minlength']) && $v['minlength']) minlength="{{ $v['minlength'] }}" @endif
                    @if(isset($v['required']) && $v['required']) required @endif >
              @endswitch
            </div>

            <ul>
              @if(isset($v['required']) && $v['required'])
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.required">
                {{ $required_field_message }}
              </li>
              @endif

              @if(isset($v['minlength']) && $v['minlength'])
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.minLength">
                {{ preg_replace('#\{value\}#', $v['minlength'], $min_length_field_message) }}
              </li>
              @endif

              @if(isset($v['maxlength']) && $v['maxlength'])
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.maxLength">
                {{ preg_replace('#\{value\}#', $v['maxlength'], $max_length_field_message) }}
              </li>
              @endif

              @if(isset($v['max']) && $v['max'])
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.maxDate">
                {{ preg_replace('#\{value\}#', $v['max'], $max_date_field_message) }}
              </li>
              @endif

              @if(isset($v['min']) && $v['min'])
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.minDate">
                {{ preg_replace('#\{value\}#', $v['min'], $min_date_field_message) }}
              </li>
              @endif

              @if(isset($v['min_choice']) && $v['min_choice'])
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.minLength">
                {{ preg_replace('#\{value\}#', $v['min_choice'], $min_choice_field_message) }}
              </li>
              @endif

              @if(isset($v['max_choice']) && $v['max_choice'])
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.maxLength">
                {{ preg_replace('#\{value\}#', $v['max_choice'], $max_choice_field_message) }}
              </li>
              @endif

              @if(isset($v['acf_fc_layout']) && $v['acf_fc_layout'] === "phone")
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.phone">
                {{ $phone_field_message }}
              </li>
              @endif

              @if(isset($v['acf_fc_layout']) && $v['acf_fc_layout'] === "email")
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.email">
                {{ $email_field_message }}
              </li>
              @endif

              @if(isset($v['acf_fc_layout']) && $v['acf_fc_layout'] === "file")
              <li class="error hide-on-load" v-if="!$v.formData.{{ $v['name'] }}.filesize">
                {{ $filesize_field_message }}
              </li>
              @endif
            </ul>
          </div>
        @endforeach
        @endif

        <input type="submit" value="Envoyer">

        <div class="lds-ripple hide-on-load" v-if="pending"><div></div><div></div></div>

        <div v-if="error && !APIResponse" class="form--error hide-on-load">
          {{ $fill_all_required_field_message }}
        </div>

        <div v-if="APIResponse && APIResponse.message" class="hide-on-load" v-bind:class="[error ? 'form--error' : success ? 'form--success' : '']">
          @{{ APIResponse.message }}
        </div>
      </form>
    </div>
  @endwhile
@endsection

<style>
.form--error {
  color: red;
}
.form--success {
  color: green;
}
</style>
