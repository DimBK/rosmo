@extends('admin.layouts.app')
@section('page_title', 'Pengaturan & SEO')
@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <ul class="nav nav-tabs mb-3" id="settingTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#hero" type="button" role="tab" aria-selected="true">Hero Section</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-selected="false">Tentang Kami</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-selected="false">SEO & Metadata</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <!-- HERO SECTION -->
                <div class="tab-pane fade show active" id="hero" role="tabpanel" tabindex="0">
                    <div class="mb-3">
                        <label class="form-label">Hero Title</label>
                        <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hero Tagline</label>
                        <textarea name="hero_tagline" class="form-control" rows="2">{{ $settings['hero_tagline'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hero Image</label>
                        @if(!empty($settings['hero_image']))
                            <div class="mb-2"><img src="{{ asset($settings['hero_image']) }}" height="100" alt="Hero Image"></div>
                        @endif
                        <input type="file" name="hero_image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Call to Action (CTA) Text</label>
                        <input type="text" name="hero_cta_text" class="form-control" value="{{ $settings['hero_cta_text'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Call to Action (CTA) Link</label>
                        <input type="text" name="hero_cta_link" class="form-control" value="{{ $settings['hero_cta_link'] ?? '' }}">
                    </div>
                </div>

                <!-- ABOUT US -->
                <div class="tab-pane fade" id="about" role="tabpanel" tabindex="0">
                    <div class="mb-3">
                        <label class="form-label">Profil Perusahaan</label>
                        <textarea name="about_profile" class="form-control" rows="4">{{ $settings['about_profile'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Visi</label>
                        <textarea name="about_vision" class="form-control" rows="3">{{ $settings['about_vision'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Misi</label>
                        <textarea name="about_mission" class="form-control" rows="3">{{ $settings['about_mission'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Kontak</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon / WhatsApp</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}">
                    </div>
                </div>

                <!-- SEO & METADATA -->
                <div class="tab-pane fade" id="seo" role="tabpanel" tabindex="0">
                    <div class="mb-3">
                        <label class="form-label">Meta Title (General)</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ $settings['meta_title'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3">{{ $settings['meta_description'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Favicon</label>
                        @if(!empty($settings['favicon']))
                            <div class="mb-2"><img src="{{ asset($settings['favicon']) }}" height="32" alt="Favicon"></div>
                        @endif
                        <input type="file" name="favicon" class="form-control" accept="image/*">
                    </div>
                    <h5 class="mt-4 border-bottom pb-2">Social Share Preview (Open Graph)</h5>
                    <div class="mb-3">
                        <label class="form-label">OG Title</label>
                        <input type="text" name="og_title" class="form-control" value="{{ $settings['og_title'] ?? '' }}" placeholder="Opsional, jika kosong akan pakai Meta Title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">OG Description</label>
                        <textarea name="og_description" class="form-control" rows="2" placeholder="Opsional, jika kosong akan pakai Meta Description">{{ $settings['og_description'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">OG Image (Gambar saat di-share ke WA/Sosmed)</label>
                        @if(!empty($settings['og_image']))
                            <div class="mb-2"><img src="{{ asset($settings['og_image']) }}" height="100" alt="OG Image"></div>
                        @endif
                        <input type="file" name="og_image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">Simpan Semua Pengaturan</button>
        </form>
    </div>
</div>
@endsection
