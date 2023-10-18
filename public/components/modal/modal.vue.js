const Modal = `

<div v-show='showModal' class="modal">
    <div v-bind:style="{ width: width + 'px' }" class='modal_container'>

        <slot name='header'></slot>

        <slot name='main'></slot>

        <slot name='footer'></slot>
        
    </div>
</div>
    
`;

Vue.component("Modal", {
    template: Modal,
    props: {
        width: {
            type: Number,
            default: 700
        }
    },
    data() {
        return {
            showModal: false
        }

    },
    methods: {
        show() {
            this.showModal = true;
        },

        hide() {
            this.showModal = false;
        }
    },
    mounted: function(){ 

    }

});