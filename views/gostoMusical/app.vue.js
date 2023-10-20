const AppTemplate = `
<div id="main">

  <div class='grid col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center'>
    <h2>Manutenção do Gênero Musical</h2>
  </div>

  <div class='grid col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>

    <div class='headGrid'>
      <button type="button" @click='openModal("Novo")' class="btn btn-primary"><i class="fa-solid fa-plus fa-lg"></i>&nbsp&nbspAdicionar</button>
      <button type="button" @click='openModal("Editar")' class="btn btn-secondary"><i class="fa-solid fa-pen-to-square fa-lg"></i>&nbsp&nbspEditar</button>
      <button type="button" @click='openModal("Deletar")' class="btn btn-danger"><i class="fa-solid fa-trash fa-lg"></i>&nbsp&nbspDeletar</button>
    </div>

    <div class='thead'>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Sequência</span></div>
      <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'><span>Gênero Musical</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Força</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Velocidade</span></div>
      <div class='col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2'><span>Inteligência</span></div>
      <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'><span>Descriçao</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Ativo</span></div>
    </div>

    <div class='tbody'>
      <div v-if='dataSourceTable.length == 0' class='genero' style='margin: 1% 0'>
        <span>Nenhum dado para carregar.</span>
      </div>
      <div v-else v-for='data in dataSourceTable' class='genero' :id='(data.CODGENERO)' @click='generoSelecionado(data)'>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.CODGENERO}}</div>
        <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'>{{data.GENERO}}</div>
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
              <label for="nome" class="form-control-label">Gênero Musical: *</label>
              <input type="text" class="form-control" id="nome" placeholder=" " v-model='dados.GENERO'>
            </div>
          </div>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="forca" class="form-control-label">Força: *</label>
              <input type="number" class="form-control" id="forca" placeholder=" " max='1' min='100' v-model='dados.FORCA'>
            </div>
          </div>

        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="velociodade" class="form-control-label">Velocidade: *</label>
              <input type="number" class="form-control" id="velociodade" placeholder=" " max='1' min='100' v-model='dados.VELOCIDADE'>
            </div>
          </div>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="inteligencia" class="form-control-label">Inteligência: *</label>
              <input type="number" class="form-control" id="inteligencia" placeholder=" " max='1' min='100' v-model='dados.INTELIGENCIA'>
            </div>
          </div>
        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>
            <div class="form-group">
              <label for="descricao" class="form-control-label">Descrição: </label>
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
      generoManipulando: {},
      showModal: false,
      modalHeader: '',
      dados: {
        CODGENERO: null,
        GENERO: null,
        FORCA: null,
        VELOCIDADE: null,
        INTELIGENCIA: null,
        DESCRICAO: null,
        ATIVO: true
      }
    }

  },
  methods: {
    getGenero() {
      axios.post(BASE + '/gostoMusical/getGenero')
      .then(resp => {
        this.dataSourceTable = resp.data;
      })
    },

    generoSelecionado(element) {
      // Verifica se tem um contato já selecionado para remover o estilo
      if (this.generoManipulando.CODGENERO) {
        document.getElementById(this.generoManipulando.CODGENERO).classList.remove('GeneroSelecionado');
      }

      this.generoManipulando = element;

      document.getElementById(element.CODGENERO).classList.add('GeneroSelecionado');
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

        if (!this.generoManipulando.CODGENERO) {
          alert('Por Favor, Selecione um registro.')
          return;
        }

        this.$refs.Modal.show();
        this.modalHeader = 'Editar';
        this.button = [
          {NOME: 'Salvar', action: this.Operacao, class: 'btn btn-outline-primary'},
          {NOME: 'Fechar', action: this.closeModal, class: 'btn btn-outline-danger'}
        ];

        this.dados.CODGENERO = this.generoManipulando.CODGENERO;
        this.dados.GENERO = this.generoManipulando.GENERO;
        this.dados.FORCA  = this.generoManipulando.FORCA;
        this.dados.VELOCIDADE = this.generoManipulando.VELOCIDADE;
        this.dados.INTELIGENCIA = this.generoManipulando.INTELIGENCIA;
        this.dados.DESCRICAO  = this.generoManipulando.DESCRICAO;
        this.dados.ATIVO  = this.generoManipulando.ATIVO == 'S' ? true : false;

        return;
      }

      if (this.acao == 'Deletar') {

        if (!this.generoManipulando.CODGENERO) {
          alert('Por Favor, Selecione um registro.')
          return;
        }
        this.dados.CODGENERO = this.generoManipulando.CODGENERO;
        this.Operacao();

        return;
      }
    },

    Operacao() {
      axios.post(BASE + '/gostoMusical/Operacao', {'dados': this.dados, 'acao': this.acao} )
      .then(resp => {
        if (resp.data.code == 1) {
          this.getGenero();
          this.closeModal();
        }
        alert(resp.data.msg);
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
    this.getGenero();
  }
});