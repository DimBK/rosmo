@php
    $hasChildren = $node->children->count() > 0;
    // We start fully expanded, or could start hidden. The class expanded means it shows minus and shows kids.
@endphp

<li class="level-{{ $level }} {{ $hasChildren ? 'has-children' : '' }} {{ $level == 1 ? 'expanded' : 'children-hidden' }}">
    <div class="org-node bg-level-{{ $level > 3 ? 3 : $level }}">
        @if($node->echelon)
            <div class="badge-echelon">{{ $node->echelon }}</div>
        @endif
        
        <div class="node-icon-wrapper">
            @if($node->image)
                <img src="{{ asset('storage/' . $node->image) }}" alt="{{ $node->position_name }}" class="node-avatar">
            @else
                <div class="default-flag-icon">
                    <div class="flag-red"></div>
                    <div class="flag-white"></div>
                </div>
            @endif
        </div>
        
        <div class="node-title">{{ $node->position_name }}</div>
        
        @if($node->official_name)
            <div class="node-subtitle-box">
                {{ $node->official_name }}
            </div>
        @endif
    </div>

    @if($hasChildren)
        <ul>
            @foreach($node->children as $child)
                @include('pages.partials.org-node', ['node' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
