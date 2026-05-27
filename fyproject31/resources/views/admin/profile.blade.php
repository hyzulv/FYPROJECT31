@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'My Profile')

@section('content')
<style>
    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr !important;
        }
        .profile-avatar-card {
            padding: 30px 20px !important;
        }
        .profile-avatar {
            width: 100px !important;
            height: 100px !important;
            font-size: 2.5rem !important;
        }
        .profile-name {
            font-size: 1.5rem !important;
        }
        .profile-edit-card, .profile-security-card {
            padding: 24px !important;
        }
    }
    @media (max-width: 480px) {
        .profile-avatar-card {
            padding: 24px 16px !important;
        }
        .profile-avatar {
            width: 80px !important;
            height: 80px !important;
            font-size: 2rem !important;
        }
        .profile-name {
            font-size: 1.3rem !important;
        }
        .profile-detail-item {
            padding: 12px 14px !important;
        }
        .profile-edit-card, .profile-security-card {
            padding: 18px !important;
        }
        .profile-edit-card h3, .profile-security-card h3 {
            font-size: 1.2rem !important;
        }
        .profile-edit-card form > div {
            flex-direction: column !important;
            gap: 8px !important;
        }
        .profile-edit-card form button {
            margin-top: 0 !important;
            width: 100% !important;
        }
        .profile-edit-card form div > div {
            width: 100% !important;
        }
    }
</style>
<div style="max-width: 100%; padding:0 20px;">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="profile-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
        <div class="profile-avatar-card" style="background: #fafafa; border: 2px solid #420C09; border-radius: 20px; padding: 50px 40px; text-align: center; box-shadow: 0 20px 60px rgba(66, 12, 9, 0.08);">
            <div class="profile-avatar" style="width: 140px; height: 140px; border-radius: 50%; background: #420C09; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; color: #fff; font-weight: bold; margin: 0 auto 25px; box-shadow: 0 8px 25px rgba(66, 12, 9, 0.3);">
                {{ substr($profile['name'] ?? 'User',0, 1) }}
            </div>
            <h2 class="profile-name" style="color: #222; font-size: 2rem; margin-bottom: 10px;">{{ $profile['name'] ?? 'User' }}</h2>
            <span style="display: inline-block; padding: 8px 24px; border-radius: 20px; background: rgba(66, 12, 9, 0.1); color: #420C09; font-size: 0.9rem; font-weight: 600; margin-bottom: 35px;">{{ ucfirst($profile['role']) }}</span>

            <div style="display: grid; gap: 16px; text-align: left; margin-top: 30px;">
                <div class="profile-detail-item" style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: #f0f0f0; border-radius: 12px; border: 1px solid rgba(66, 12, 9, 0.1);">
                    <span style="font-size: 1.5rem;">📧</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #666; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Email</span>
                        <span style="color: #222; font-size: 1rem; font-weight: 500;">{{ $profile['email'] ?? '-' }}</span>
                    </div>
                </div>
                <div class="profile-detail-item" style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: #f0f0f0; border-radius: 12px; border: 1px solid rgba(66, 12, 9, 0.1);">
                    <span style="font-size: 1.5rem;">👤</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #666; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Username</span>
                        <span style="color: #222; font-size: 1rem; font-weight: 500;">{{ $profile['username'] ?? '-' }}</span>
                    </div>
                </div>
                <div class="profile-detail-item" style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: #f0f0f0; border-radius: 12px; border: 1px solid rgba(66, 12, 9, 0.1);">
                    <span style="font-size: 1.5rem;">📱</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #666; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Phone</span>
                        <span style="color: #222; font-size: 1rem; font-weight: 500;">{{ $profile['phone'] ?? '-' }}</span>
                    </div>
                </div>
                <div class="profile-detail-item" style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: #f0f0f0; border-radius: 12px; border: 1px solid rgba(66, 12, 9, 0.1);">
                    <span style="font-size: 1.5rem;">📅</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #666; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Joined</span>
                        <span style="color: #222; font-size: 1rem; font-weight: 500;">{{ $profile['join_date'] ?? '-' }}</span>
                    </div>
                </div>
                <div class="profile-detail-item" style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: #f0f0f0; border-radius: 12px; border: 1px solid rgba(66, 12, 9, 0.1);">
                    <span style="font-size: 1.5rem;">🟢</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #666; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Status</span>
                        <span style="color: #28a745; font-size: 1rem; font-weight: 500;">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="profile-edit-card" style="background: #fafafa; border: 2px solid #420C09; border-radius: 20px; padding: 40px; margin-bottom: 20px; box-shadow: 0 15px 40px rgba(66, 12, 9, 0.08);">
                <h3 style="color: #420C09; font-size: 1.5rem; margin-bottom: 25px;">Edit Profile</h3>

                <form action="{{ route($prefix . '.profile.update.name') }}" method="POST" style="margin-bottom: 20px;">
                    @csrf
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="flex: 1;">
                            <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Name</label>
                            <input type="text" name="name" value="{{ $profile['name'] ?? '' }}" required style="width: 100%; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 1rem; transition: all 0.3s ease;">
                        </div>
                        <button type="submit" style="margin-top: 24px; padding: 12px 24px; background: #420C09; border: none; border-radius: 10px; color: #fff; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease;">Update</button>
                    </div>
                </form>

                <form action="{{ route($prefix . '.profile.update.email') }}" method="POST" style="margin-bottom: 20px;">
                    @csrf
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="flex: 1;">
                            <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Email</label>
                            <input type="email" name="email" value="{{ $profile['email'] ?? '' }}" required style="width: 100%; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 1rem; transition: all 0.3s ease;">
                        </div>
                        <button type="submit" style="margin-top: 24px; padding: 12px 24px; background: #420C09; border: none; border-radius: 10px; color: #fff; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease;">Update</button>
                    </div>
                </form>

                <form action="{{ route($prefix . '.profile.update.phone') }}" method="POST">
                    @csrf
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="flex: 1;">
                            <label style="display: block; color: #420C09; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Phone</label>
                            <div style="display: flex; align-items: center; gap: 0;">
                                <span style="padding: 12px 10px 12px 15px; background: #e0e0e0; border: 1px solid #ddd; border-right: none; border-radius: 10px 0 0 10px; color: #555; font-size: 1rem; font-weight: 600;">+60</span>
                                <input type="tel" name="phone" value="{{ preg_replace('/^\+60/', '', $profile['phone'] ?? '') }}" maxlength="10" style="flex: 1; padding: 12px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 0 10px 10px 0; color: #222; font-size: 1rem; transition: all 0.3s ease;" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                        </div>
                        <button type="submit" style="margin-top: 24px; padding: 12px 24px; background: #420C09; border: none; border-radius: 10px; color: #fff; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease;">Update</button>
                    </div>
                </form>
            </div>

            <div class="profile-security-card" style="background: #fafafa; border: 2px solid #420C09; border-radius: 20px; padding: 40px; box-shadow: 0 15px 40px rgba(66, 12, 9, 0.08);">
                <h3 style="color: #420C09; font-size: 1.5rem; margin-bottom: 12px;">Security</h3>
                <p style="color: #666; font-size: 0.95rem; margin-bottom: 20px;">Change your password to keep your account secure</p>
                <a href="{{ route($prefix . '.change-password') }}" style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; background: rgba(66, 12, 9, 0.08); border: 1px solid rgba(66, 12, 9, 0.25); border-radius: 10px; color: #420C09; text-decoration: none; font-size: 1rem; font-weight: 600; transition: all 0.3s ease;">
                    🔒 Change Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
