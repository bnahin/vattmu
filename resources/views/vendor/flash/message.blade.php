@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="flash-alert callout
                    callout-{{ $message['level'] }}
        {{ $message['important'] ? 'alert-important' : '' }}"
             role="alert"
        >
            @if ($message['important'])
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                >&times;
                </button>
            @endif
            @if($message['level'] == 'success')
                <i class="fas fa-check"></i>
            @endif
            @if($message['level'] == 'danger')
                <i class="fas fa-exclamation-triangle"></i>
            @endif
            {!! $message['message'] !!}
        </div>
    @endif
@endforeach

@php
session()->forget('flash_notification')
@endphp
