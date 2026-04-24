@extends('layouts.app')

@section('title', 'Struktur Organisasi')

@push('styles')
<style>
    .org-chart-section {
        position: relative;
        background-color: #fcfcfc;
        min-height: 100vh;
        padding: 40px 0 80px;
        color: #333;
    }

    /* CSS Tree Structure */
    .tree-wrapper {
        width: 100%;
        overflow-x: auto;
        text-align: center;
        padding: 20px 0;
    }

    .tree {
        display: inline-flex;
        min-width: max-content;
        justify-content: center;
        align-items: flex-start;
        margin: 0 auto;
    }

    .tree ul {
        padding-top: 25px;
        position: relative;
        transition: all 0.5s;
        display: flex;
        justify-content: center;
        padding-left: 0;
    }

    .tree li {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 25px 10px 0 10px;
        transition: all 0.5s;
    }

    /* Connecting lines */
    .tree li::before, .tree li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 2px solid #5a6b7c;
        width: 50%;
        height: 25px;
    }

    .tree li::after {
        right: auto;
        left: 50%;
        border-left: 2px solid #5a6b7c;
    }

    /* Remove left/right formatting from single items */
    .tree li:only-child::after, .tree li:only-child::before {
        display: none;
    }
    .tree li:only-child {
        padding-top: 0;
    }

    /* Remove left/right line from first/last child */
    .tree li:first-child::before, .tree li:last-child::after {
        border: 0 none;
    }

    /* Add back the vertical line to the first/last nodes */
    .tree li:last-child::before {
        border-right: 2px solid #5a6b7c;
        border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after {
        border-radius: 5px 0 0 0;
    }

    /* The line down from parents */
    .tree ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px solid #5a6b7c;
        width: 0;
        height: 25px;
    }

    /* Card Wrapper */
    .org-node {
        text-decoration: none;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        z-index: 2;
        padding: 20px 15px;
        border-radius: 12px;
        min-width: 180px;
        color: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .org-node:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .bg-level-1 { background-color: #d9534f; }
    .bg-level-2 { background-color: #5cb85c; }
    .bg-level-3 { background-color: #4a7fdc; }

    .badge-echelon {
        position: absolute;
        top: -12px;
        right: -15px;
        background-color: #f0ad4e;
        color: #fff;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 700;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        z-index: 10;
        white-space: nowrap;
    }

    .node-icon-wrapper {
        margin-bottom: 12px;
    }

    .node-avatar {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.9);
        background-color: #fff;
    }

    .default-flag-icon {
        width: 40px;
        height: 30px;
        border-radius: 5px;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .flag-red {
        width: 100%;
        height: 50%;
        background-color: #ce2b28;
    }

    .flag-white {
        width: 100%;
        height: 50%;
        background-color: #f8f8f8;
    }

    .node-title {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 10px;
        color: #fff;
        text-align: center;
        letter-spacing: 0.5px;
        line-height: 1.3;
        max-width: 150px;
    }

    .node-subtitle-box {
        background-color: rgba(255, 255, 255, 0.25);
        border-radius: 6px;
        padding: 6px 8px;
        font-size: 0.7rem;
        width: 100%;
        text-align: center;
        color: #fff;
        font-weight: 600;
        max-width: 160px;
    }

    /* Toggled state */
    .children-hidden > ul {
        display: none !important;
    }
    
    .has-children > .org-node::after {
        content: '+';
        position: absolute;
        bottom: -35px; /* Adjusting for the border distance */
        left: 50%;
        transform: translateX(-50%);
        background: #fdfdfd;
        border: 2px solid #5a6b7c;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        line-height: 18px;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        color: #333;
        z-index: 5;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .has-children.expanded > .org-node::after {
        content: '-';
    }

    .has-children > .org-node:hover::after {
        background-color: #e0e0e0;
    }

</style>
@endpush

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url('{{ asset('assets/img/alam.jpeg') }}');">
      <div class="container position-relative">
        <h1>Struktur Organisasi Kementerian Kehutanan</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">Struktur Organisasi</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <section class="org-chart-section">
        <div class="container-fluid">
            <div class="tree-wrapper">
                <div class="tree" id="org-tree">
                    @if($rootStructures->count() > 0)
                        <ul>
                            @foreach($rootStructures as $node)
                                @include('pages.partials.org-node', ['node' => $node, 'level' => 1])
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center w-100">
                            <p>Struktur Organisasi belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleNodes = document.querySelectorAll('.has-children > .org-node');
        
        toggleNodes.forEach(node => {
            node.addEventListener('click', function(e) {
                e.preventDefault();
                const parentLi = this.parentElement;
                
                if (parentLi.classList.contains('children-hidden')) {
                    parentLi.classList.remove('children-hidden');
                    parentLi.classList.add('expanded');
                } else {
                    parentLi.classList.add('children-hidden');
                    parentLi.classList.remove('expanded');
                }
            });
        });
        
        // Let's expand up to level 2 initially and hide others if it's too big
        // Or keep everything expanded. The user wants them to appear when clicked,
        // so we might hide level 2+ initially.
        /*
        const lowerLevels = document.querySelectorAll('.tree .level-2'); // LI elements that are children
        lowerLevels.forEach(li => {
            if (li.classList.contains('has-children')) {
                li.classList.add('children-hidden');
                li.classList.remove('expanded');
            }
        });
        */
    });
</script>
@endpush
