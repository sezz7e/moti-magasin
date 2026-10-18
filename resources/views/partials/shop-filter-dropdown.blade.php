{{-- vars: $id, $label, $name, $type ('checkbox'|'radio'), $options [value => [label, count, color?]], $selected --}}
<div class="dropdown dropdown-filter">
    <div class="dropdown-toggle" id="f-{{ $id }}" data-bs-toggle="dropdown" aria-expanded="false"
         data-bs-auto-close="outside" role="button">
        <span class="text-uppercase">{{ $label }}</span>
        <span class="icon icon-arrow-angle-down"></span>
    </div>
    <div class="dropdown-menu" aria-labelledby="f-{{ $id }}">
        <ul class="filter-group-check">
            @foreach($options as $value => $opt)
                @php
                    $checked = in_array((string) $value, array_map('strval', $selected), true);
                    $off = $opt['count'] === 0 && ! $checked;
                @endphp
                <li class="list-item {{ $off ? 'disabled' : '' }}">
                    <input type="{{ $type }}" name="{{ $name }}{{ $type === 'checkbox' ? '[]' : '' }}" value="{{ $value }}"
                           class="tf-check style-2" id="f-{{ $id }}-{{ $loop->index }}" @checked($checked) @disabled($off)>
                    <label for="f-{{ $id }}-{{ $loop->index }}" class="label">
                        @isset($opt['color'])
                            <span style="display:inline-block;width:14px;height:14px;border-radius:50%;background:{{ $opt['color'] }};border:1px solid rgba(0,0,0,.15);margin-right:8px;vertical-align:middle;"></span>
                        @endisset
                        <span>{{ $opt['label'] }}</span><span class="count-wrap">[ <span class="count">{{ $opt['count'] }}</span> ]</span>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
</div>