# 🔗 Livelinks - React Resource Triage

O **Livelinks** é uma ferramenta de curadoria e triagem de links focada no ecossistema **React**. Desenvolvido para centralizar referências, documentações e componentes, o projeto utiliza uma stack moderna e performática para garantir agilidade na navegação e organização.

## 🚀 Tech Stack

O projeto foi construído focando em simplicidade e reatividade:

* **Framework:** [Laravel 10+](https://laravel.com/)
* **Frontend Interactivity:** [Alpine.js](https://alpinejs.dev/) (para manipulação de DOM e estados sem refresh)
* **Styling:** [Tailwind CSS](https://tailwindcss.com/)
* **Database:** SQLite / MySQL (dependendo do seu ambiente)

## 🎯 O Desafio
O foco principal deste projeto foi resolver o caos de salvar referências de React em diversos lugares. A triagem permite categorizar links de bibliotecas (Hooks, State Management, UI Libraries) de forma eficiente.

## ✨ Funcionalidades

* **Triagem Dinâmica:** Filtros rápidos para encontrar recursos específicos de React.
* **Interface Reativa:** Graças ao Alpine.js, a experiência de filtragem e adição de links é instantânea.

## 🛠️ Como rodar o projeto

1. Clone o repositório:
   ```bash
   git clone [https://github.com/Xoppee/livelinks.git](https://github.com/Xoppee/livelinks.git)

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
