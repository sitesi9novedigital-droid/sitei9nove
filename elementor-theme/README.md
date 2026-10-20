# i9nove Digital — Elementor

Versão do layout de referência para **Elementor gratuito**. Não depende de Elementor Pro, de construtor adicional de cabeçalhos ou de plugins de widgets.

## Instalação

1. Instale e ative o plugin **Elementor Website Builder**, em Plugins → Adicionar plugin.
2. Em Aparência → Temas → Adicionar tema → Enviar tema, envie **i9nove-elementor.zip** e ative **i9nove Digital Elementor**.
3. Vá a **Aparência → Configurar i9nove** e clique em **Importar layout e definir como página inicial**.
4. O importador cria três páginas: **Início — i9nove**, **Cabeçalho — i9nove** e **Rodapé — i9nove**. Elas podem ser editadas pelos links dessa tela ou por Páginas → Editar com Elementor.
5. Edite os títulos, textos, imagens, links e botões diretamente no Elementor. Use o Navegador/Estrutura para selecionar seções e colunas.

A importação define a nova página inicial em Configurações → Leitura. Páginas e posts existentes são preservados. Repetir a importação não sobrescreve os documentos já criados nem duplica as páginas; apenas recria páginas ausentes. O importador guarda a configuração anterior em `i9_elementor_previous_front`; você pode voltar à página anterior por Configurações → Leitura.

## Cabeçalho e rodapé sem Elementor Pro

O tema renderiza as páginas de cabeçalho e rodapé como documentos Elementor compartilhados. Portanto, a edição acontece em **Páginas**, e não no Theme Builder do Elementor Pro. Os documentos auxiliares recebem `noindex`. Use o modelo de página **Padrão** para manter o cabeçalho e o rodapé do tema; o modelo Elementor Canvas os oculta.

O menu usa links no widget Editor de texto do cabeçalho. No celular, o tema fornece o botão que abre e fecha esses links. Edite os textos e destinos no mesmo widget; preserve a marcação `nav` e a classe avançada `i9-menu` para manter o comportamento móvel. Atualize links com `/` se o site for instalado em um subdiretório.

## Blog

O widget **Shortcode** com `[i9nove_posts]` mostra os três posts publicados mais recentes, com imagem destacada, título, data e link. Publique os artigos em **Posts**. Não requer o widget Posts do Elementor Pro. Sem artigos, há uma mensagem de conteúdo em breve.

## Antes de publicar

- Substitua `contato@example.com` pelo e-mail ou link de WhatsApp real no botão de contato. Remova a orientação visível dessa seção.
- Substitua projetos e imagens ilustrativas por materiais aprovados. Confira os indicadores de resultados do modelo.
- O logotipo atual é tipográfico e pode ser substituído por um widget de imagem.
- As imagens incluídas pertencem ao tema; o Elementor permite substituí-las por arquivos da biblioteca de mídia. Não exclua o tema enquanto usar essas imagens.

## Técnica e licenças

Tema clássico PHP com widgets nativos do Elementor: título, texto, imagem, botão e shortcode. Os JSON em `templates` são usados pelo importador, que resolve os caminhos das imagens para a instalação atual. Não é necessário importar esses arquivos manualmente.

Requer WordPress 6.6+ e PHP 7.4+; recomendado PHP 8.3. A licença do código é GPL-2.0-or-later. Fontes Poppins incluídas sob SIL OFL e fotografias arquitetônicas CC0: veja `CREDITS.md` e `assets/fonts/OFL.txt`. O plugin Elementor é instalado separadamente e não é incluído no ZIP do tema.

## Desenvolvimento neste repositório

Na raiz, execute `npm ci` e `npm run dev:elementor` (Node 24.18+, npm 11.16+). O script prepara WordPress 6.8.3 e o pacote oficial Elementor 3.34.0 em `/tmp`, verifica o SHA-256 do pacote e inicia PHP 8.3/SQLite pelo Playground na porta 9401. Abra a tela de configuração do tema para importar o layout. As credenciais do Playground são apenas de desenvolvimento. Use o checkout existente; não é necessário criar worktree. Para empacotar, execute `npm run package:elementor`.
