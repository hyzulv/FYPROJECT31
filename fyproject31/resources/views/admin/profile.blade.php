@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'My Profile')

@section('content')
<div style="max-width: 100%; padding:0 20px;">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
        <div style="background: linear-gradient(145deg, #1a1a1a, #111111); border: 1px solid rgba(209, 152, 106, 0.3); border-radius: 20px; padding: 50px 40px; text-align: center; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);">
            <div style="width: 140px; height: 140px; border-radius: 50%; background: linear-gradient(135deg, #d1986a, #b8834f); display: flex; align-items: center; justify-content: center; font-size: 3.5rem; color: #000; font-weight: bold; margin: 0 auto 25px; box-shadow: 0 8px 25px rgba(209, 152, 106, 0.3);">
                {{ substr($profile['name'] ?? 'User',0, 1) }}
            </div>
            <h2 style="color: #fff; font-size: 2rem; margin-bottom: 10px;">{{ $profile['name'] ?? 'User' }}</h2>
            <span style="display: inline-block; padding: 8px 24px; border-radius: 20px; background: rgba(209, 152, 106, 0.2); color: #d1986a; font-size: 0.9rem; font-weight: 600; margin-bottom: 35px;">{{ ucfirst($profile['role']) }}</span>

            <div style="display: grid; gap: 16px; text-align: left; margin-top: 30px;">
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(209, 152, 106, 0.08);">
                    <span style="font-size: 1.5rem;">📧</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Email</span>
                        <span style="color: #fff; font-size: 1rem; font-weight: 500;">{{ $profile['email'] ?? '-' }}</span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(209, 152, 106, 0.08);">
                    <span style="font-size: 1.5rem;">👤</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Username</span>
                        <span style="color: #fff; font-size: 1rem; font-weight: 500;">{{ $profile['username'] ?? '-' }}</span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(209, 152, 106, 0.08);">
                    <span style="font-size: 1.5rem;">📱</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Phone</span>
                        <span style="color: #fff; font-size: 1rem; font-weight: 500;">{{ $profile['phone'] ?? '-' }}</span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(209, 152, 106, 0.08);">
                    <span style="font-size: 1.5rem;">📅</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Joined</span>
                        <span style="color: #fff; font-size: 1rem; font-weight: 500;">{{ $profile['join_date'] ?? '-' }}</span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(209, 152, 106, 0.08);">
                    <span style="font-size: 1.5rem;">🟢</span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Status</span>
                        <span style="color: #28a745; font-size: 1rem; font-weight: 500;">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div style="background: linear-gradient(145deg, #1a1a1a, #111111); border: 1px solid rgba(209, 152, 106, 0.3); border-radius: 20px; padding: 40px; margin-bottom: 20px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);">
                <h3 style="color: #d1986a; font-size: 1.5rem; margin-bottom: 25px;">Edit Profile</h3>

                <form action="{{ route($prefix . '.profile.update.name') }}" method="POST" style="margin-bottom: 20px;">
                    @csrf
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="flex: 1;">
                            <label style="display: block; color: #d1986a; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Name</label>
                            <input type="text" name="name" value="{{ $profile['name'] ?? '' }}" required style="width: 100%; padding: 12px 15px; background: #2a2a2a; border: 1px solid rgba(209, 152, 106, 0.2); border-radius: 10px; color: #fff; font-size: 1rem; transition: all 0.3s ease;">
                        </div>
                        <button type="submit" style="margin-top: 24px; padding: 12px 24px; background: linear-gradient(135deg, #d1986a, #b8834f); border: none; border-radius: 10px; color: #000; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease;">Update</button>
                    </div>
                </form>

                <form action="{{ route($prefix . '.profile.update.email') }}" method="POST" style="margin-bottom: 20px;">
                    @csrf
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="flex: 1;">
                            <label style="display: block; color: #d1986a; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Email</label>
                            <input type="email" name="email" value="{{ $profile['email'] ?? '' }}" required style="width: 100%; padding: 12px 15px; background: #2a2a2a; border: 1px solid rgba(209, 152, 106, 0.2); border-radius: 10px; color: #fff; font-size: 1rem; transition: all 0.3s ease;">
                        </div>
                        <button type="submit" style="margin-top: 24px; padding: 12px 24px; background: linear-gradient(135deg, #d1986a, #b8834f); border: none; border-radius: 10px; color: #000; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease;">Update</button>
                    </div>
                </form>

                <form action="{{ route($prefix . '.profile.update.phone') }}" method="POST">
                    @csrf
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="flex: 1;">
                            <label style="display: block; color: #d1986a; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Phone</label>
                            <input type="tel" name="phone" value="{{ $profile['phone'] ?? '' }}" maxlength="15" style="width: 100%; padding: 12px 15px; background: #2a2a2a; border: 1px solid rgba(209, 152, 106, 0.2); border-radius: 10px; color: #fff; font-size: 1rem; transition: all 0.3s ease;" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <button type="submit" style="margin-top: 24px; padding: 12px 24px; background: linear-gradient(135deg, #d1986a, #b8834f); border: none; border-radius: 10px; color: #000; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease;">Update</button>
                    </div>
                </form>
            </div>

            <div style="background: linear-gradient(145deg, #1a1a1a, #111111); border: 1px solid rgba(209, 152, 106, 0.3); border-radius: 20px; padding: 40px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);">
                <h3 style="color: #d1986a; font-size: 1.5rem; margin-bottom: 12px;">Security</h3>
                <p style="color: #888; font-size: 0.95rem; margin-bottom: 20px;">Change your password to keep your account secure</p>
                <a href="{{ route($prefix . '.change-password') }}" style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; background: rgba(209, 152, 106, 0.1); border: 1px solid rgba(209, 152, 106, 0.3); border-radius: 10px; color: #d1986a; text-decoration: none; font-size: 1rem; font-weight: 600; transition: all 0.3s ease;">
                    🔒 Change Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
