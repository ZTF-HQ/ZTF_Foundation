<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-blue-500 to-sky-400 px-4">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8">
            
            {{-- Header --}}
            <div class="flex flex-col items-center mb-8">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-600 to-blue-500 flex items-center justify-center text-white font-bold text-3xl shadow-md">
                    {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->email ?? 'U', 0, 1)) }}
                </div>
                <h1 class="mt-4 text-xl font-bold text-gray-800">
                    Bienvenue 👋
                </h1>
                <p class="text-gray-600 text-sm">
                    {{ Auth::user()->name ?? Auth::user()->email ?? 'Utilisateur' }}
                </p>
            </div>

            {{-- User Info --}}
            <div class="bg-gray-50 rounded-xl p-5 mb-8 border border-gray-100 space-y-3">
                <div class="flex items-center gap-3 text-gray-700 text-sm">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>
                    <span><span class="font-medium">Matricule :</span> {{ Auth::user()->matricule ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700 text-sm">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m12-6H4a2 2 0 00-2 2v12h20V8a2 2 0 00-2-2z"/></svg>
                    <span><span class="font-medium">Email :</span> {{ Auth::user()->email ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700 text-sm">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/></svg>
                    <span><span class="font-medium">Inscription :</span> {{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : '-' }}</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-indigo-300 transition">
                    <svg class="w-6 h-6 text-indigo-600 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-3.33 0-6 2-6 4v2h12v-2c0-2-2.67-4-6-4z"/></svg>
                    <span class="text-xs font-medium text-gray-700">Profil</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-indigo-300 transition">
                    <svg class="w-6 h-6 text-indigo-600 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2h6v2m-9 4h12V9H3v12zM9 9V7a3 3 0 016 0v2"/></svg>
                    <span class="text-xs font-medium text-gray-700">Services</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-indigo-300 transition">
                    <svg class="w-6 h-6 text-indigo-600 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3M6 6a9 9 0 1112 12 9 9 0 01-12-12z"/></svg>
                    <span class="text-xs font-medium text-gray-700">Paramètres</span>
                </a>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 text-red-500 hover:text-red-600 font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5"/></svg>
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
