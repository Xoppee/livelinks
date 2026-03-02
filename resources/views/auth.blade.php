<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveLinks - Acesso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { background-color: #0f0f12; }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6 font-sans">

    <div class="max-w-md w-full bg-[#16161a] rounded-[2rem] shadow-2xl border border-slate-800 overflow-hidden"
        x-data="authForm()" x-cloak>

        <div class="flex border-b border-slate-800 bg-[#1c1c22]">
            <button @click="tab = 'login'"
                :class="tab === 'login' ? 'text-indigo-400 border-b-2 border-indigo-400 bg-indigo-400/5' : 'text-slate-500 hover:text-slate-300'"
                class="flex-1 py-5 font-bold uppercase tracking-widest text-xs transition-all outline-none">
                Login
            </button>
            <button @click="tab = 'register'"
                :class="tab === 'register' ? 'text-cyan-400 border-b-2 border-cyan-400 bg-cyan-400/5' : 'text-slate-500 hover:text-slate-300'"
                class="flex-1 py-5 font-bold uppercase tracking-widest text-xs transition-all outline-none">
                Registro
            </button>
        </div>

        <div class="p-10">
            <template x-if="message">
                <div :class="message.type === 'error' ? 'bg-red-500/10 text-red-400 border-red-500/50' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/50'"
                     class="mb-6 p-4 rounded-xl border text-sm text-center">
                    <span x-text="message.text"></span>
                </div>
            </template>

            <div x-show="tab === 'login'" x-transition>
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-white">Olá!</h2>
                    <p class="text-slate-500 mt-2">Entre para gerenciar seus links.</p>
                </div>
                
                <form @submit.prevent="submitLogin" class="space-y-5">
                    @csrf {{-- Proteção CSRF do Laravel --}}
                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2">Email</label>
                        <input type="email" x-model="loginData.email" required
                            class="w-full bg-[#0f0f12] border border-slate-700 rounded-xl py-3 px-4 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2">Senha</label>
                        <input type="password" x-model="loginData.password" required
                            class="w-full bg-[#0f0f12] border border-slate-700 rounded-xl py-3 px-4 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <button type="submit" :disabled="loading"
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 rounded-2xl transition-all flex justify-center">
                        <span x-show="!loading">ENTRAR</span>
                        <div x-show="loading" class="animate-spin rounded-full h-5 w-5 border-2 border-white/30 border-t-white"></div>
                    </button>
                </form>
            </div>

            <div x-show="tab === 'register'" x-transition>
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-white">Criar Conta</h2>
                    <p class="text-slate-500 mt-2">Comece a organizar sua live hoje.</p>
                </div>
                
                <form @submit.prevent="submitRegister" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-slate-400 text-xs font-bold uppercase mb-2">Nome</label>
                            <input type="text" x-model="regData.name" required
                                class="w-full bg-[#0f0f12] border border-slate-700 rounded-xl py-3 px-4 text-white focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-400 text-xs font-bold uppercase mb-2">User</label>
                            <input type="text" x-model="regData.username" required
                                class="w-full bg-[#0f0f12] border border-slate-700 rounded-xl py-3 px-4 text-white focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2">Email</label>
                        <input type="email" x-model="regData.email" required
                            class="w-full bg-[#0f0f12] border border-slate-700 rounded-xl py-3 px-4 text-white focus:ring-2 focus:ring-cyan-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-slate-400 text-xs font-bold uppercase mb-2">Senha</label>
                        <input type="password" x-model="regData.password" required
                            class="w-full bg-[#0f0f12] border border-slate-700 rounded-xl py-3 px-4 text-white focus:ring-2 focus:ring-cyan-500 outline-none">
                    </div>
                    <button type="submit" :disabled="loading"
                        class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-4 rounded-2xl transition-all flex justify-center">
                        <span x-show="!loading">CADASTRAR</span>
                        <div x-show="loading" class="animate-spin rounded-full h-5 w-5 border-2 border-white/30 border-t-white"></div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function authForm() {
            return {
                tab: 'login',
                loading: false,
                message: null,
                loginData: { email: '', password: '' },
                regData: { name: '', username: '', email: '', password: '' },

                // O Blade gera as URLs automaticamente para você aqui:
                routes: {
                    login: "{{ url('/api/login') }}",
                    register: "{{ url('/api/register') }}",
                    dashboard: "{{ url('/home') }}" // Altere para sua rota real
                },

                async submitLogin() {
                    this.loading = true;
                    this.message = null;

                    try {
                        const response = await fetch(this.routes.login, {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}" // Laravel exige isso
                            },
                            body: JSON.stringify(this.loginData)
                        });

                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Erro nas credenciais');

                        localStorage.setItem('token', data.access_token);
                        this.message = { type: 'success', text: 'Bem-vindo! Redirecionando...' };
                        setTimeout(() => window.location.href = this.routes.dashboard, 1000);

                    } catch (err) {
                        this.message = { type: 'error', text: err.message };
                    } finally { this.loading = false; }
                },

                async submitRegister() {
                    this.loading = true;
                    this.message = null;

                    try {
                        const response = await fetch(this.routes.register, {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify(this.regData)
                        });

                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Erro no cadastro');

                        this.message = { type: 'success', text: 'Conta criada com sucesso!' };
                        this.tab = 'login';
                    } catch (err) {
                        this.message = { type: 'error', text: err.message };
                    } finally { this.loading = false; }
                }
            }
        }
    </script>
</body>
</html>