<!DOCTYPE html>
<html lang="{{ $langCode }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $profile->title }} - {{ $profile->user->name }}</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #2D3748;
            line-height: 1.5;
            font-size: 11pt;
        }
        h1 {
            font-size: 24pt;
            margin: 0 0 5px 0;
            color: #1A202C;
        }
        .subtitle {
            font-size: 14pt;
            color: #4A5568;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .contact-info {
            font-size: 10pt;
            color: #718096;
            margin-bottom: 25px;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 15px;
        }
        h2 {
            font-size: 14pt;
            color: #2B6CB0;
            text-transform: uppercase;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 2px solid #2B6CB0;
            padding-bottom: 3px;
        }
        .section-item {
            margin-bottom: 15px;
        }
        .item-header {
            font-weight: bold;
            color: #2D3748;
        }
        .item-sub {
            font-style: italic;
            color: #4A5568;
            font-size: 10pt;
            margin-bottom: 5px;
        }
        .item-details {
            text-align: justify;
            white-space: pre-line;
        }
        .skills-list {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

    <h1>{{ $profile->user->name }}</h1>
    <div class="subtitle">{{ $profile->title }}</div>

    <div class="contact-info">
        @if($profile->email) Email: {{ $profile->email }} | @endif
        @if($profile->phone) Telefone: {{ $profile->phone }} | @endif
        @if($profile->whatsapp) WhatsApp: {{ $profile->whatsapp }} <br> @endif
        @if($profile->linkedin) LinkedIn: {{ $profile->linkedin }} | @endif
        @if($profile->website) Portfolio: {{ $profile->website }} | @endif
        @if($profile->city) Localidade: {{ $profile->city->name }}, {{ $profile->state->name ?? '' }} @endif
    </div>

    @if($profile->about)
        <h2>{{ __('Summary') }}</h2>
        <div class="item-details">{{ $profile->about }}</div>
    @endif

    @if($profile->experiences->count() > 0)
        <h2>{{ __('Professional Experience') }}</h2>
        @foreach($profile->experiences as $exp)
            <div class="section-item">
                <div class="item-header">{{ $exp->title }}</div>
                <div class="item-sub">
                    {{ $exp->company }} |
                    {{ \Carbon\Carbon::parse($exp->start_date)->format('m/Y') }} –
                    {{ $exp->current_here ? __('Currently here') : \Carbon\Carbon::parse($exp->finish_date)->format('m/Y') }}
                </div>
                @if($exp->key_skills)
                    <div class="item-sub"><strong>{{ __('Key skills') }}:</strong> {{ $exp->key_skills }}</div>
                @endif
                @if($exp->about)
                    <div class="item-details">{{ $exp->about }}</div>
                @endif
            </div>
        @endforeach
    @endif

    @if($profile->academics->count() > 0)
        <h2>{{ __('Education') }}</h2>
        @foreach($profile->academics as $academic)
            <div class="section-item">
                <div class="item-header">{{ $academic->degree }} em {{ $academic->title }}</div>
                <div class="item-sub">
                    {{ $academic->school }} |
                    {{ \Carbon\Carbon::parse($academic->start_date)->format('m/Y') }} –
                    {{ $academic->current_here ? __('Currently here') : \Carbon\Carbon::parse($academic->finish_date)->format('m/Y') }}
                </div>
                @if($academic->about)
                    <div class="item-details">{{ $academic->about }}</div>
                @endif
            </div>
        @endforeach
    @endif

    @if($profile->skills->count() > 0)
        <h2>{{ __('Skills') }}</h2>
        <div class="skills-list">
            @foreach($profile->skills as $skillData)
                {{-- Procurando o modelo Skill na tabela dinâmica caso use pivot ou relação direta --}}
                <strong>{{ $skillData->name ?? \App\Models\Skill::find($skillData->skill_id)?->name }}:</strong>
                {{ $skillData->experience_years }} {{ __('Experience years') }}{{ !$loop->last ? ' • ' : '' }}
            @endforeach
        </div>
    @endif

    @if($profile->languages->count() > 0)
        <h2>{{ __('Languages') }}</h2>
        <div class="skills-list">
            @foreach($profile->languages as $lang)
                <strong>{{ \App\Models\Language::find($lang->language_id)?->name }}:</strong> {{ ucfirst($lang->level) }}{{ !$loop->last ? ' | ' : '' }}
            @endforeach
        </div>
    @endif

</body>
</html>
