<template>
<div class="p-2 mx-auto ">
  <!-- Modal Edit Init -->
  <div v-if="isEditing" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeEditModal">&times;</span>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
          <label for="name">Nome do Fornecedor</label>
          <input v-model="supplier.name" type="text" placeholder="Digite o nome"  class="form-control">
          <label for="name">Telefone de Contato</label>
          <input v-model="supplier.contact_phone" type="text" placeholder="Digite o telefone"  class="form-control">
        </div>
        <div class="mb-3">
          <label for="name">E-mail de Contato</label>
          <input v-model="supplier.contact_email" type="text" placeholder="Digite o e-mail"  class="form-control">
          <label for="name">CEP</label>
          <input v-model="supplier.address.cep" type="text" placeholder="Digite o CEP"  class="form-control" @blur="fetchAddress">
        </div>
        <div class="mb-3">
          <label for="complemento">Complemento</label>
          <input v-model="supplier.address.complemento" type="text" placeholder="Complemento" class="form-control">

          <label for="bairro">Bairro</label>
          <input v-model="supplier.address.bairro" type="text" placeholder="Bairro" class="form-control">

          <label for="bairro">Número</label>
          <input v-model="supplier.address.numero" type="text" placeholder="Número" class="form-control">
        </div>
        <div class="mb-3">
        <label for="localidade">Localidade</label>
          <input v-model="supplier.address.localidade" type="text" placeholder="Localidade" class="form-control">

          <label for="uf">UF</label>
          <input v-model="supplier.address.uf" type="text" placeholder="UF" class="form-control">
        </div> 
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
      </div>
    </div>
  <!-- Modal Edit End -->
  <div class="card text-dark bg-light mt-2 p-2" v-if="showCreateModal">
    <div class="card-body ">
      <form @submit.prevent="submitForm" class="row g-3">
        <div class="col-md-6 mt-2">
          <label for="name">Nome do Fornecedor</label>
          <input v-model="supplier.name" type="text" placeholder="Digite o nome"  class="form-control">
          <label for="name">Telefone de Contato</label>
          <input v-model="supplier.contact_phone" type="text" placeholder="Digite o telefone"  class="form-control">
        </div>
        <div class="col-md-6 mt-2">
          <label for="name">E-mail de Contato</label>
          <input v-model="supplier.contact_email" type="text" placeholder="Digite o e-mail"  class="form-control">
          <label for="name">CEP</label>
          <input v-model="supplier.address.cep" type="text" placeholder="Digite o CEP"  class="form-control" @blur="fetchAddress">
        </div>
        <div class="col-md-6 mt-2">
          <label for="complemento">Complemento</label>
          <input v-model="supplier.address.complemento" type="text" placeholder="Complemento" class="form-control">

          <label for="bairro">Bairro</label>
          <input v-model="supplier.address.bairro" type="text" placeholder="Bairro" class="form-control">

          <label for="bairro">Número</label>
          <input v-model="supplier.address.numero" type="text" placeholder="Número" class="form-control">
        </div>
        <div class="col-md-6 mt-2">
        <label for="localidade">Localidade</label>
          <input v-model="supplier.address.localidade" type="text" placeholder="Localidade" class="form-control">

          <label for="uf">UF</label>
          <input v-model="supplier.address.uf" type="text" placeholder="UF" class="form-control">
        </div> 
        <button type="submit" class="btn btn-primary">Cadastrar</button>
      </form>
    </div>
  </div>
  <div style="max-height: 500px; overflow-y: auto;">
  <table class="table table-dark table-striped mt-2">
  <thead class="text-center">
    <tr>
      <th>Nome</th>
      <th>Telefone</th>
      <th>E-mail</th>
      <th>CEP</th>
      <th>Logradouro</th>
      <th>Complemento</th>
      <th>Bairro</th>
      <th>Localidade</th>
      <th>UF</th>
      <th>Número</th>
      <th><button class="btn btn-success col" @click="toggleCreateModal" >Adicionar</button></th>
      <th></th>
    </tr>
  </thead>
  <tbody class="text-center">
    <tr v-for="supplier in suppliers" :key="supplier.id">
      <td>{{ supplier.name }}</td>
      <td>{{ supplier.contact_phone }}</td>
      <td>{{ supplier.contact_email }}</td>
      <td>{{ supplier.address.cep }}</td>
      <td>{{ supplier.address.logradouro }}</td>
      <td>{{ supplier.address.complemento }}</td>
      <td>{{ supplier.address.bairro }}</td>
      <td>{{ supplier.address.localidade }}</td>
      <td>{{ supplier.address.uf }}</td>
      <td>{{ supplier.address.numero }}</td>
      <td><button class="btn btn-primary" @click="editSupplier(supplier.id)">Editar</button></td>
      <td><button class="btn btn-danger" @click="deleteSupplier(supplier.id)">Excluir</button></td>
    </tr>
  </tbody>
</table>
</div>
</div>


</template>

<script>
import axios from 'axios';
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

export default {
  components: {
    VueTelInput,
  },
  data() {
    return {
      supplier: {
        name: '',
        contact_phone: '',
        
        tableKey: 0,
        contact_email: '',
        address: {
          cep: '',
          logradouro: '',
          complemento:  '',
          bairro: '',
          localidade:  '',
          uf:  '',
          numero:  '',
        },
      },
      
      isEditing: false,
      editingSupplierId: null,
      showCreateModal: false,
      suppliers: [],
    };
  },
  methods: {
    fetchSuppliers() {
            axios.get('/api/fornecedores')
          .then(response => {
            this.suppliers = response.data.map(supplier => ({
              ...supplier,
              address: JSON.parse(supplier.address),
              contact_phone: supplier.contact_phone,
              
            }));
          })
          .catch(error => {
            // handle error
          });
      },
    async fetchAddress() {
     const response = await axios.get(`https://viacep.com.br/ws/${this.supplier.address.cep}/json/`);
      this.supplier.address = { ...this.supplier.address, ...response.data };
     },
     closeEditModal() {
      this.isEditing = false;
     },
     toggleCreateModal() {
      this.showCreateModal = !this.showCreateModal;
      if (this.showCreateModal) {
        this.resetSupplierForm();
      }
    },
    resetSupplierForm() {
      this.supplier = {
     
        name: '',
        contact_phone: '',
        contact_email: '',
        address: '',
    
      };
    },
    openModal() {
      this.isModalOpen = true;
      this.supplier = {
       id: supplier.id,
      };
    },
    closeModal() {
      this.isModalOpen = false;
    },
    editSupplier(id) {
  axios.get(`/fornecedores/${id}/details`)
    .then(response => {
      const address = JSON.parse(response.data.address);
      this.supplier = {
        name: response.data.name,
        contact_email: response.data.contact_email,
        contact_phone: response.data.contact_phone,
        address: {
          cep: address.cep,
          logradouro: address.logradouro,
          complemento: address.complemento,
          bairro: address.bairro,
          localidade: address.localidade,
          uf: address.uf,
          numero: address.numero,
        },
      };
      this.editingSupplierId = id;
      this.isEditing = true;
    })
    .catch(error => {
      // handle error
    });
},
    openEditModal(supplier) {
      this.isEditing = true;
      this.supplier = { ...supplier };
    },
     deleteSupplier(id) {
        axios.delete(`/fornecedores/${id}`)
          .then(response => {
            this.fetchSuppliers();
          })
          .catch(error => {
            
          });
      },
      submitForm() {
    if (this.isEditing) {
      axios.put(`/fornecedores/${this.editingSupplierId}`, this.supplier)
        .then(response => {
          this.fetchSuppliers();
          this.closeEditModal();
        })
        .catch(error => {
          // handle error
        });
    } else {
      const supplierData = {
        name: this.supplier.name,
        contact_email: this.supplier.contact_email,
        contact_phone: this.supplier.contact_phone,
        address: {
          cep: this.supplier.address.cep,
          logradouro: this.supplier.address.logradouro,
          complemento: this.supplier.address.complemento,
          bairro: this.supplier.address.bairro,
          localidade: this.supplier.address.localidade,
          uf: this.supplier.address.uf,
          numero: this.supplier.address.numero,
        },
      };
      axios.post(`/fornecedores/create`, supplierData)
        .then(response => {
          this.fetchSuppliers();
        })
        .catch(error => {
          // handle error
        });
    }
  },
},
  mounted() {
      this.fetchSuppliers();
    }
};
</script>

<style>
  .modal {
    display: block;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
  }
  
  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }
  
  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }
  
  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  </style>