{{--
    Quote / contact form. Works as a normal POST; app.js upgrades it to an
    in-page submit. $selected = service slug to pre-select.
--}}
@props(['selected' => null, 'id' => 'quote-form'])
<form class="quote-form" id="{{ $id }}" method="post" action="{{ route('contact.store') }}" data-ajax novalidate>
    @csrf
    <input type="hidden" name="page" value="{{ url()->current() }}">
    <div class="hp" aria-hidden="true">
        <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
    </div>

    @if (session('form_success'))
        <p class="form-msg form-msg--ok" role="status">{{ session('form_success') }}</p>
    @endif

    <div class="field-grid">
        <div class="field">
            <label for="{{ $id }}-name">Full name <span aria-hidden="true">*</span></label>
            <input id="{{ $id }}-name" name="name" type="text" autocomplete="name" required maxlength="120" value="{{ old('name') }}">
            @error('name')<p class="field__error">{{ $message }}</p>@enderror
        </div>
        <div class="field">
            <label for="{{ $id }}-phone">Phone / WhatsApp <span aria-hidden="true">*</span></label>
            <input id="{{ $id }}-phone" name="phone" type="tel" autocomplete="tel" inputmode="tel" required maxlength="40" value="{{ old('phone') }}" placeholder="+971">
            @error('phone')<p class="field__error">{{ $message }}</p>@enderror
        </div>
        <div class="field">
            <label for="{{ $id }}-email">Email</label>
            <input id="{{ $id }}-email" name="email" type="email" autocomplete="email" maxlength="160" value="{{ old('email') }}">
            @error('email')<p class="field__error">{{ $message }}</p>@enderror
        </div>
        <div class="field">
            <label for="{{ $id }}-service">Service needed</label>
            <select id="{{ $id }}-service" name="service">
                <option value="">Select a service</option>
                @foreach (\App\Support\Content::services() as $s)
                    <option value="{{ $s['slug'] }}" @selected(old('service', $selected) === $s['slug'])>{{ $s['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="field field--full">
            <label for="{{ $id }}-message">Project details</label>
            <textarea id="{{ $id }}-message" name="message" rows="4" maxlength="3000" placeholder="Location, size and number of openings, wall/slab thickness, timeline…">{{ old('message') }}</textarea>
        </div>
    </div>

    <div class="quote-form__foot">
        <button type="submit" class="btn btn--primary">
            Send enquiry
        </button>
        <p class="quote-form__note">Or call <a href="{{ tel_link() }}">{{ config('site.phone') }}</a> — 24/7</p>
    </div>
    <p class="form-msg" data-form-msg role="status" aria-live="polite" hidden></p>
</form>
