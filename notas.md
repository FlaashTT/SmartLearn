# Notas do Projeto FelixBus
--- 
## ✅ Concluído
- **Criação de cursos gerais**
  _Localização do ficheiro:_
  - `\src\vies\layout\admin\layout_categorias.html`

- **Tabela forms de satisfação:**
  _Localização do ficheiro:_  
  - `src\views\layout\admin\layout_relatorio_satisfacao.html`

- **Pre realização na parte dos utilizadores com campos adminstradores e clientes**
  _Localização do ficheiro:_  
  - `src\views\layout\admin\layout_utlizadores_admin.html`

- **Criacão da pagina configuracoes de site para o direitos de autor sobre o rodapé**
  _Localização do ficheiro:_  
  - `src\views\layout\admin\layout.....`


---
## 🔧 Em Progresso

- NDA

## 📌 Para Fazer
- [X] Sitio onde tem dados das respostas dos forms de satisfação dos clientes

- Estilo do `modalEditarCategoria.php`

- Pensar em provedores possíveis:  
  - pessoal (dado pelo próprio criador)  
  - YouTube  
  - Facebook  
  - outros

- Finalizar `relatorio_logs.php` com as ações completas

- Em `categoria_curso.php`, fazer o modal como no `gerenciar_admin.php` (na mesma página)


---
 
## 🐞 Bugs a Corrigir

### Categorias
  
- Idioma "Curso em Inglês" não está a funcionar  
- Sem desconto diz ter 2, mas só mostra 1  
- Falta tratamento de níveis (avançado e iniciante)  
- Falta tratamento de duração (de 1 a 3 horas)  
- Filtros com 5 estrelas / sem classificação  
- Filtros por categorias  
- Filtros "mais de 60 euros"
  
### Erro Crítico ❗
```txt
Fatal error: Uncaught ArgumentCountError: The number of elements in the type definition string must match the number of bind variables in C:\xampp\htdocs\SmartLearn\public\perfil\perfil_carteira.php:36 Stack trace: #0 C:\xampp\htdocs\SmartLearn\public\perfil\perfil_carteira.php(36): mysqli_stmt->bind_param('issii', 32, '%cur%', '%cur%', '%cur%', 10, 0) #1 {main} thrown in C:\xampp\htdocs\SmartLearn\public\perfil\perfil_carteira.php on line 36
```



---

## 🔍 Estado de Páginas

- 🟠 Página feita e verificada de bugs  
- 🟢 Verificar se não há bugs  
- 🟡 A ser trabalhado / incompleto  
- 🔴 Nem comecei  
- 🔵 Falta CSS  
- 🟣 Com bugs

---
## 💡 Ideias Futuras

- *(Sem ideias listadas por agora)*

---
## Dificuldades no processo

- Dificuldade a realizar os filtros da página geral de cursos

