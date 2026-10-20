# i9nove Digital — tema WordPress de blocos

Tema baseado no layout de referência: hero, essência, soluções, processo, projetos, sobre, blog, chamada de contato e rodapé. Não precisa de Elementor ou plugins de blocos.

## Instalar

1. No WordPress 6.6 ou superior, abra **Aparência → Temas → Adicionar tema → Enviar tema**.
2. Envie `i9nove-digital.zip` e ative **i9nove Digital**. Recomendado PHP 8.3; mínimo 7.4.
3. Abra **Aparência → Editor → Design → Modelos → Página inicial**. Edite diretamente os textos, imagens e botões. A visualização em lista facilita selecionar cada seção.
4. Edite cabeçalho e rodapé em **Editor → Padrões → Partes de modelo**. Cores e tipografia ficam em **Estilos**.
5. Publique posts com imagem destacada para preencher automaticamente o blog. Sem posts, aparece uma mensagem de novos conteúdos em breve.

A página inicial é fornecida pelo modelo `front-page.html`; não é necessário importar conteúdo ou criar uma página. O padrão **Página inicial i9nove** também pode ser inserido em uma página pelo inseridor de padrões. Mudanças salvas no Editor do Site ficam no banco do WordPress e têm prioridade sobre os arquivos do tema.

## Antes de publicar

- Substitua `contato@example.com` no botão final pelo e-mail real ou por um link de WhatsApp (`https://wa.me/55DDDNUMERO`). Remova o texto de orientação da seção de contato.
- Atualize o menu e o link do logotipo se o WordPress estiver em um subdiretório.
- Troque as imagens e os projetos ilustrativos pelos materiais aprovados da agência. Os indicadores de resultados vieram da referência e devem ser confirmados.
- Os projetos são cartões de demonstração editáveis. Você pode adicionar links pelos blocos de imagem/título. O tema não cria um tipo de conteúdo de portfólio.
- As ilustrações vetoriais são incluídas no tema; novas imagens devem ser enviadas pela biblioteca de mídia nos formatos usuais, como JPG, PNG ou WebP.

## Recursos

- Blocos nativos: grupos, colunas, títulos, imagens, botões, navegação e consulta de posts.
- Layout com largura máxima de 1140px, quatro cartões no desktop, dois no tablet e um no celular.
- Fontes Poppins locais; não depende de Google Fonts em produção.
- Navegação móvel nativa, foco visível e respeito à preferência por movimento reduzido.
- Modelos de página, post, arquivo, busca e erro 404.

## Desenvolvimento

O tema em si não tem etapa de build. O servidor de teste usa WordPress Playground (PHP WebAssembly e SQLite), fora do pacote do tema. Requer Node 24.18+, npm 11.16+ e Git. Execute `npm ci` e `npm run dev`; `tools/dev.sh` prepara o WordPress 6.8.3 em `/tmp/i9-wordpress`. Use o checkout existente: cada tarefa na nuvem já é isolada, sem necessidade de worktree. O servidor é apenas para desenvolvimento local; não utilize as credenciais de demonstração em produção.

Para gerar um ZIP instalável, execute `python3 tools/package.py`. A saída fica em `dist/i9nove-digital.zip` (ignorada pelo Git).

## Licenças

Código e ilustrações: GPL-2.0-or-later. Poppins: SIL Open Font License, incluída em `assets/fonts/OFL.txt`. Fotos arquitetônicas: CC0, oriundas do tema oficial Twenty Twenty-Four; veja `CREDITS.md`.
