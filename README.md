# 🔗 Livelinks - Streamer Content Triage

O **Livelinks** é uma ferramenta de curadoria e triagem de conteúdos focada na dinâmica de **React** para streamers. Desenvolvido para organizar e centralizar links de vídeos, matérias e sugestões da comunidade, o projeto garante agilidade na navegação durante as transmissões ao vivo. 

Inspirado na plataforma **iLuLives**, o sistema permite que o criador de conteúdo gerencie sua "fila" de reações de forma limpa e performática.

## 🚀 Tech Stack

O projeto foi construído focando em simplicidade e reatividade em tempo real:

* **Framework:** [Laravel 10+](https://laravel.com/)
* **Frontend Interactivity:** [Alpine.js](https://alpinejs.dev/) (Para filtros e manipulação de estados sem refresh na live)
* **Styling:** [Tailwind CSS](https://tailwindcss.com/)
* **Database:** MySQL

## 🎯 O Desafio
O foco principal foi resolver o caos de gerenciar múltiplos links (YouTube, Twitter/X, TikTok) durante uma live. A triagem permite que o streamer categorize e acesse conteúdos rapidamente, mantendo o fluxo do entretenimento sem interrupções técnicas.

## ✨ Funcionalidades

* **Triagem de Conteúdo:** Filtros rápidos para organizar o que será reagido a seguir.
* **Interface Low-Latency:** Graças ao Alpine.js, a experiência de gerenciar a fila de links é instantânea.
* **Organização Inspirada em Lives:** Fluxo de trabalho pensado especificamente para criadores de conteúdo.

## 🛠️ Como rodar o projeto

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/Xoppee/livelinks.git

2. Instale as dependências PHP:
   ```bash
   composer install

3. Rode as migrations:
  ```bash
  php artisan migrate
   ```
4. Inicie o servidor:
   ```bash
   php artisan serve
