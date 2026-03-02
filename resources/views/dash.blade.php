<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveLinks - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-[#0f0f12] text-slate-200 min-h-screen flex" x-data="linkManager({{ Js::from($links) }}, {{ auth()->id() }}, {{ $streamer->id_user ?? auth()->id() }})">

    <aside class="w-64 bg-[#16161a] border-r border-slate-800 flex flex-col py-6 shrink-0 transition-all">
        <div class="flex items-center gap-3 px-6 mb-10 text-indigo-500 font-bold">
            <i data-lucide="monitor" class="w-8 h-8"></i>
            <span class="text-lg tracking-tight">LiveLinks</span>
        </div>

        <nav class="flex flex-col gap-2 px-4 mb-10">
            <a href="#" class="flex items-center gap-3 p-3 bg-indigo-600/10 text-indigo-400 rounded-xl">
                <i data-lucide="layout-grid" class="w-5"></i> <span class="text-sm font-medium">Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 text-slate-500 hover:text-white transition">
                <i data-lucide="music" class="w-5"></i> <span class="text-sm font-medium">Músicas</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 text-slate-500 hover:text-white transition">
                <i data-lucide="settings" class="w-5"></i> <span class="text-sm font-medium">Configurações</span>
            </a>
        </nav>

        <div class="px-4 overflow-y-auto flex-1">
            <h3 class="text-[10px] font-bold text-slate-600 uppercase tracking-widest mb-4 px-2">Equipe de Moderação
            </h3>
            <div class="flex flex-col gap-2">
                @foreach ($moderators as $mod)
                    <div
                        class="flex items-center gap-3 bg-slate-800/20 p-2 rounded-xl border border-white/5 hover:border-white/10 transition group">
                        <img src="{{ $mod->user->avatar_user }}"
                            class="w-8 h-8 rounded-full border border-indigo-500/30">
                        <div class="flex flex-col min-w-0">
                            <span class="text-[11px] font-bold text-slate-200 truncate">{{ $mod->user->name }}</span>
                            <span class="text-[9px] text-slate-500">@ {{ $mod->user->username }}</span>
                        </div>
                        @if (auth()->id() == ($streamer->id_user ?? auth()->id()))
                            <button
                                class="ml-auto opacity-0 group-hover:opacity-100 text-red-500/50 hover:text-red-500 transition">
                                <i data-lucide="x-circle" class="w-4"></i>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-auto px-6 pt-6 border-t border-slate-800 flex flex-col gap-4">
            <div class="flex items-center gap-3 text-slate-500 hover:text-white cursor-pointer transition">
                <i data-lucide="bell" class="w-5"></i> <span class="text-sm">Notificações</span>
            </div>
            <div @click="logout()"
                class="flex items-center gap-3 text-red-500/70 hover:text-red-500 cursor-pointer transition">
                <i data-lucide="log-out" class="w-5"></i> <span class="text-sm font-bold">Sair</span>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        <header
            class="h-16 border-b border-slate-800 flex items-center justify-between px-8 bg-[#0f0f12]/80 backdrop-blur-md shrink-0">
            <div class="flex items-center gap-4">
                <div
                    class="bg-slate-800 px-3 py-1.5 rounded-lg text-sm font-bold flex items-center gap-2 border border-slate-700">
                    <span class="text-slate-300">{{ auth()->user()->name }}</span>
                    <template x-if="isModerator">
                        <span
                            class="text-[9px] bg-amber-500/20 text-amber-500 px-1.5 py-0.5 rounded uppercase font-black">MOD</span>
                    </template>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-white">{{ auth()->user()->username }}</p>
                    <p class="text-[10px] text-indigo-400">Canal Ativo</p>
                </div>
                <img src="{{ auth()->user()->avatar_user }}"
                    class="w-10 h-10 rounded-xl border-2 border-indigo-500 shadow-lg shadow-indigo-500/20">
            </div>
        </header>

        <div
            class="flex-1 flex flex-col items-center justify-center p-6 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-indigo-500/5 via-transparent to-transparent">

            <div class="flex bg-[#16161a] p-1 rounded-2xl mb-12 border border-slate-800 shadow-2xl">
                <button @click="activeTab = 'pendentes'" class="px-8 py-2.5 rounded-xl text-sm font-bold transition-all"
                    :class="activeTab === 'pendentes' ? 'bg-indigo-600 text-white shadow-lg' :
                        'text-slate-500 hover:text-slate-300'">Links</button>
                <button @click="activeTab = 'aleatorios'"
                    class="px-8 py-2.5 rounded-xl text-sm font-bold transition-all"
                    :class="activeTab === 'aleatorios' ? 'bg-indigo-600 text-white shadow-lg' :
                        'text-slate-500 hover:text-slate-300'">Aleatórios</button>
                <button @click="activeTab = 'assistidos'"
                    class="px-8 py-2.5 rounded-xl text-sm font-bold transition-all"
                    :class="activeTab === 'assistidos' ? 'bg-indigo-600 text-white shadow-lg' :
                        'text-slate-500 hover:text-slate-300'">Assistidos</button>
            </div>

            <template x-if="links.length === 0">
                <div class="text-center" x-transition x-cloak>
                    <div class="bg-indigo-500/10 p-8 rounded-[2.5rem] inline-block mb-4 border border-indigo-500/20">
                        <i data-lucide="check-circle" class="w-16 h-16 text-indigo-500"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Fila Limpa!</h2>
                    <p class="text-slate-500 mt-1">Todos os links foram revisados pela staff.</p>
                </div>
            </template>

            <template x-if="links.length > 0">
                <div class="w-full flex flex-col items-center" x-cloak>
                    <p
                        class="text-slate-500 text-[10px] mb-6 font-black uppercase tracking-[0.3em] flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-ping"></span>
                        Link <span x-text="currentIndex + 1" class="text-white"></span> de <span
                            x-text="links.length"></span>
                    </p>

                    <div class="w-full max-w-[480px] bg-[#16161a] rounded-[3rem] border border-white/10 p-2 shadow-2xl transition-all"
                        x-show="currentLink" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                        <div
                            class="bg-[#1c1c22] rounded-[2.8rem] p-10 flex flex-col items-center text-center relative overflow-hidden">

                            <div class="bg-indigo-500/5 px-6 py-4 rounded-2xl text-sm text-indigo-200/80 mb-8 border border-indigo-500/10 w-full italic leading-relaxed"
                                x-text="currentLink.message || 'O usuário não deixou nenhuma mensagem.'">
                            </div>

                            <div class="relative mb-8">
                                <div
                                    class="w-28 h-28 bg-indigo-600 rounded-[2.5rem] rotate-12 absolute opacity-20 animate-pulse">
                                </div>
                                <div
                                    class="w-28 h-28 bg-[#16161a] rounded-[2.5rem] border-2 border-indigo-500/50 flex items-center justify-center relative shadow-2xl shadow-indigo-500/20">
                                    <i data-lucide="youtube" class="w-14 h-14 text-indigo-400"
                                        x-show="currentLink.link_url.includes('youtube.com') || currentLink.link_url.includes('youtu.be')"></i>
                                    <i data-lucide="link" class="w-14 h-14 text-indigo-400"
                                        x-show="!currentLink.link_url.includes('youtube')"></i>
                                </div>
                            </div>

                            <h3 class="text-3xl font-black text-white mb-8 tracking-tight truncate w-full"
                                x-text="currentLink.username"></h3>

                            <div class="flex gap-6 mb-10">
                                <a :href="currentLink.link_url" target="_blank"
                                    class="w-14 h-14 flex items-center justify-center bg-slate-800 rounded-2xl text-slate-400 hover:text-white hover:bg-indigo-600 transition-all shadow-xl hover:-translate-y-1">
                                    <i data-lucide="external-link" class="w-6"></i>
                                </a>
                                <button
                                    @click="isModerator ? approveLink(currentLink.id_link) : markAsWatched(currentLink.id_link)"
                                    class="w-20 h-20 flex items-center justify-center bg-emerald-500/10 rounded-3xl text-emerald-500 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white transition-all shadow-xl hover:-translate-y-1">
                                    <i data-lucide="check" class="w-10"></i>
                                </button>
                                <button @click="banLink(currentLink.id_link)"
                                    class="w-14 h-14 flex items-center justify-center bg-red-500/10 rounded-2xl text-red-500 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all shadow-xl hover:-translate-y-1">
                                    <i data-lucide="trash-2" class="w-6"></i>
                                </button>
                            </div>

                            <div class="w-full bg-[#0f0f12] py-4 px-6 rounded-2xl border border-slate-800 font-mono text-indigo-400 text-xs mb-6 truncate cursor-pointer hover:border-indigo-500/50 transition relative group"
                                @click="copyToClipboard(currentLink.link_url)">
                                <span x-text="currentLink.link_url"></span>
                                <div
                                    class="absolute inset-0 bg-indigo-600 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-[10px] text-white font-bold uppercase tracking-widest rounded-2xl">
                                    Copiar Link
                                </div>
                            </div>

                            <p
                                class="text-[10px] text-slate-600 uppercase flex items-center gap-2 font-bold tracking-[0.2em]">
                                <i data-lucide="clock" class="w-3"></i> Recebido às <span
                                    x-text="formatDate(currentLink.created_at)"></span>
                            </p>
                        </div>
                    </div>

                    <button @click="nextLink()"
                        class="mt-10 bg-slate-800/50 hover:bg-slate-800 text-slate-400 hover:text-white font-bold py-4 px-12 rounded-2xl transition-all border border-slate-700 active:scale-95 flex items-center gap-3 group">
                        Pular Link <i data-lucide="chevron-right"
                            class="w-5 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </template>
        </div>
    </main>

    <script>
        function linkManager(initialLinks, userId, streamerId) {
            return {
                links: initialLinks,
                currentIndex: 0,
                activeTab: 'pendentes',
                userId: userId,
                streamerId: streamerId,
                isModerator: userId != streamerId,

                init() {
                    this.$nextTick(() => lucide.createIcons());
                },

                get currentLink() {
                    return this.links[this.currentIndex] || null;
                },

                nextLink() {
                    if (this.links.length <= 1) return;
                    this.currentIndex = (this.currentIndex + 1) % this.links.length;
                    this.refreshIcons();
                },

                async markAsWatched(id) {
                    const res = await this.apiCall(`/api/links/${id}/watched`, 'PATCH');
                    if (res.ok) this.removeLinkFromList(id);
                },

                async approveLink(id) {
                    const res = await this.apiCall(`/api/moderator/accept/${id}`, 'POST');
                    if (res.ok) {
                        this.removeLinkFromList(id);
                        alert('Link aprovado! Agora o streamer pode ver.');
                    }
                },

                async banLink(id) {
                    if (!confirm('Deseja excluir este link?')) return;
                    const res = await this.apiCall(`/api/links/${id}`, 'DELETE');
                    if (res.ok) this.removeLinkFromList(id);
                },

                async apiCall(url, method) {
                    try {
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        if (!response.ok) throw await response.json();
                        return {
                            ok: true
                        };
                    } catch (err) {
                        alert(err.error || 'Erro na operação');
                        return {
                            ok: false
                        };
                    }
                },

                removeLinkFromList(id) {
                    this.links = this.links.filter(l => l.id_link !== id);
                    if (this.currentIndex >= this.links.length) this.currentIndex = 0;
                    this.refreshIcons();
                },

                refreshIcons() {
                    this.$nextTick(() => lucide.createIcons());
                },

                copyToClipboard(text) {
                    navigator.clipboard.writeText(text);
                },

                formatDate(dateStr) {
                    if (!dateStr) return 'agora';
                    const date = new Date(dateStr);
                    return date.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },

                logout() {
                    localStorage.removeItem('token');
                    window.location.href = '/auth';
                }
            }
        }
    </script>
</body>

</html>
