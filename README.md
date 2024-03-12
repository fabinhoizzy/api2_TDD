Projeto de API para estudo em TDD

Nesse projeto estou usando o docker com sail para usar o Laravel

# 
- [x] salvar um endpoint
  - [x] Precisar enviar o endpoint que queremos escurtar
  - [x] endpoint tem que ser válido
  - [x] não pode se repetir
  - [x] esperamos receber um url encurtada pd1.test/YH21
  - [x] esperamos receber um status code 201
- [x] Deletar a url curta baseado na url gerada
  - [x] url precisa existir
  - [x] receber um 204 [no content] caso deletado com sucesso
- [] Pegar estatistica de uso da url /stats/YH21
  - [] ultima vez que foi utilizada
