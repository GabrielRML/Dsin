const AppTemplate = `
<div id="main">

  <div class='grid col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center'>
    <h2>Manutenção dos Jogos</h2>
  </div>

  <div class='grid col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>

    <div class='headGrid'>
      <button type="button" @click='openModal("Novo")' class="btn btn-primary"><i class="fa-solid fa-user"></i>&nbsp&nbspAdicionar</button>
      <button type="button" @click='openModal("Editar")' class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i>&nbsp&nbspEditar</button>
      <button type="button" @click='openModal("Excluir")' class="btn btn-danger"><i class="fa-solid fa-trash fa-lg"></i>&nbsp&nbspExcluir</button>
    </div>

    <div class='thead'>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Sequência</span></div>
      <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'><span>Nome</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Força</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Velocidade</span></div>
      <div class='col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2'><span>Inteligência</span></div>
      <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'><span>Descriçao</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Ativo</span></div>
    </div>

    <div class='tbody'>
      <div v-if='dataSourceTable.length == 0' class='jogos' style='margin: 1% 0'>
        <span>Nenhum dado para carregar.</span>
      </div>
      <div v-else v-for='data in dataSourceTable' class='jogos' :id='(data.CODJOGO)' @click='jogoSelecionado(data)'>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.CODJOGO}}</div>
        <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'>{{data.NOME}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.FORCA}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.VELOCIDADE}}</div>
        <div class='col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2'>{{data.INTELIGENCIA}}</div>
        <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'>{{data.DESCRICAO}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.ATIVO}}</div>
      </div>
    </div>

  </div>

  <Modal ref='Modal' :width='800'>
    <h4 slot='header'>{{modalHeader}}</h4>

    <div slot='main'>
      <div>
        <div class='row'>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="nome" class="form-control-label">Nome</label>
              <input type="text" class="form-control" id="nome" placeholder=" " v-model='dados.NOME'>
            </div>
          </div>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="forca" class="form-control-label">Força</label>
              <input type="number" class="form-control" id="forca" placeholder=" " max='1' min='100' v-model='dados.FORCA'>
            </div>
          </div>

        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="velociodade" class="form-control-label">Velocidade</label>
              <input type="number" class="form-control" id="velociodade" placeholder=" " max='1' min='100' v-model='dados.VELOCIDADE'>
            </div>
          </div>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="inteligencia" class="form-control-label">Inteligência</label>
              <input type="number" class="form-control" id="inteligencia" placeholder=" " max='1' min='100' v-model='dados.INTELIGENCIA'>
            </div>
          </div>
        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>
            <div class="form-group">
              <label for="descricao" class="form-control-label">Descrição</label>
              <textarea class="form-control" id="descricao" rows="3" required v-model='dados.DESCRICAO'></textarea>
            </div>
          </div>
        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex justify-content-center'>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="ativar_desativar" v-model='dados.ATIVO'>
              <label class="form-check-label" for="ativar_desativar">Ativar/Desativar</label>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div slot='footer'>
      <div class='button'>
        <button type='button' v-for="b in button" :class='b.class' @click="b.action()">
          {{ b.NOME }}
        </button>
      </div>
    </div>

    </Modal>

</div>

`;

Vue.component("AppVue", {
  template: AppTemplate,
  data() {
    return {
      acao: '',
      button: '',
      dataSourceTable: [],
      jogoManipulando: {},
      showModal: false,
      modalHeader: '',
      dados: {
        CODJOGO: null,
        NOME: null,
        FORCA: null,
        VELOCIDADE: null,
        INTELIGENCIA: null,
        DESCRICAO: null,
        ATIVO: true
      }
    }

  },
  methods: {
    getJogos() {
      axios.post(BASE + '/jogos/getJogos')
      .then(resp => {
        this.dataSourceTable = resp.data;
      })
    },

    jogoSelecionado(element) {
      // Verifica se tem um contato já selecionado para remover o estilo
      if (this.jogoManipulando.CODJOGO) {
        document.getElementById(this.jogoManipulando.CODJOGO).classList.remove('JogoSelecionado');
      }

      this.jogoManipulando = element;

      document.getElementById(element.CODJOGO).classList.add('JogoSelecionado');
    },

    openModal(acao) {
      this.acao = acao;

      if (this.acao == 'Novo') {

        this.$refs.Modal.show();
        this.modalHeader = 'Novo';
        this.button = [
          {NOME: 'Salvar', action: this.Operacao, class: 'btn btn-outline-primary'},
          {NOME: 'Fechar', action: this.closeModal, class: 'btn btn-outline-danger'}
        ];
        return;
      }

      if (this.acao == 'Editar') {

        if (!this.jogoManipulando.CODJOGO) {
          alert('Por Favor, Selecione um registro.')
          return;
        }

        this.$refs.Modal.show();
        this.modalHeader = 'Editar';
        this.button = [
          {NOME: 'Salvar', action: this.Operacao, class: 'btn btn-outline-primary'},
          {NOME: 'Fechar', action: this.closeModal, class: 'btn btn-outline-danger'}
        ];

        this.dados.CODJOGO = this.jogoManipulando.CODJOGO;
        this.dados.NOME = this.jogoManipulando.NOME;
        this.dados.FORCA  = this.jogoManipulando.FORCA;
        this.dados.VELOCIDADE = this.jogoManipulando.VELOCIDADE;
        this.dados.INTELIGENCIA = this.jogoManipulando.INTELIGENCIA;
        this.dados.DESCRICAO  = this.jogoManipulando.DESCRICAO;
        this.dados.ATIVO  = this.jogoManipulando.ATIVO == 'S' ? true : false;

        return;
      }

      if (this.acao == 'Excluir') {

        if (!this.jogoManipulando.CODJOGO) {
          alert('Por Favor, Selecione um registro.')
          return;
        }

        this.dados.CODJOGO = this.jogoManipulando.CODJOGO;

        const msg = `Deseja excluir o Jogo: ${this.jogoManipulando.NOME} / Seq.: ${this.jogoManipulando.CODJOGO} ?`;
        
        if (confirm(msg))
          this.Operacao();
          this.getJogos();
          return;

      }
    },

    Operacao() {
      axios.post(BASE + '/jogos/Operacao', {'dados': this.dados, 'acao': this.acao} )
      .then(resp => {
        if (resp.data.code == 1) {
          this.getJogos();
          this.closeModal();
          alert(resp.data.msg);
          return;
        }
        if (resp.data.code == 0) {
          alert(resp.data.msg);
          return;
        }
        alert('Erro ao realizar operação; O Jogo pode estar sendo usado por um Hospedeiro.');
        return;
      })
    },

    limparCampos() {
      for (var campo in this.dados) {
        this.dados[campo] = null;
      }
      this.dados.ATIVO = true;
      this.button = null;
      this.modalHeader = null;
    },

    closeModal() {
      this.$refs.Modal.hide();
      this.limparCampos();
    },
  },
  mounted: function(){
    this.getJogos();
  }
});