<template>
    <div class="p-2 mx-auto ">
    <div class="card text-white bg-dark mt-2 p-2" v-if="showCreateModal">
    <div class="card-body ">
      <form @submit.prevent="submitForm" class="row g-3">
        <div class="col-md-6 mt-2">
            <label for="code_lb" class="form-label">Código</label>
            <input v-model="product.code" type="text" placeholder="Digite o código"  class="form-control">
            <label for="name_lb" class="form-label">Nome</label>
            <input v-model="product.name" type="text" placeholder="Digite o nome"  class="form-control">
        </div>
        <div class="col-md-6 mt-2">
          <label for="supplier_lb" class="form-label">Fornecedor</label>
          <select v-model="product.supplier" class="form-control">
            <option disabled value="">Selecione um fornecedor</option>
            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
              {{ supplier.name }}
            </option>
          </select>
            <label for="price_lb" class="form-label">Preço Unitário</label>
            <input v-model="product.price_unit" type="number" placeholder="Digite o preço" class="form-control">
        </div>
        <div class="col-md-6 mt-2">
          <label for="category_lb" class="form-label">Categoria</label>
            <input v-model="product.category" type="text" placeholder="Digite uma Categoria" class="form-control">
            <label for="qnt_lb" class="form-label">Quantidade em Estoque</label>
            <input v-model="product.quantity_stock" type="number" placeholder="Digite a quantidade"  class="form-control">
        </div>
        <div class="col-md-6 mt-2">
          
          <label for="desc_lb" class="form-label">Descrição</label>
            <textarea v-model="product.description" placeholder="Digite a descrição" class="form-control "></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Cadastrar</button>
      </form>
    </div>
    </div>
      <table class="table table-dark table-striped mt-2 rounded">
        <thead class="text-center">
          <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço Unitário</th>
            <th>Categoria</th>
            <th>Fornecedor</th>
            <th>Quantidade em Estoque</th>
            <th><button class="btn btn-success col" @click="toggleCreateModal" >Adicionar</button></th>
            <th></th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="product in products" :key="product.id">
            <td>{{ product.code }}</td>
            <td>{{ product.name }}</td>
            <td v-text="product.description.length > 50 ? product.description.slice(0, 20) + '...' : product.description"></td>
            <td>{{ product.price_unit }}</td>
            <td>{{ product.category }}</td>
            <td>{{ product.supplier }}</td>
            <td>{{ product.quantity_stock }}</td>
            <td><button class="btn btn-primary" @click="editProduct(product.id)">Editar</button></td>
            <td><button class="btn btn-danger" @click="deleteProduct(product.id)">Excluir</button></td>
          </tr>
        </tbody>
      </table>
       <!-- Modal de Edição -->
    <div v-if="isEditing" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeEditModal">&times;</span>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label for="edit-code" class="form-label">Código</label>
            <input v-model="product.code" type="text" id="edit-code" class="form-control">
          </div>
          <div class="mb-3">
            <label for="edit-name" class="form-label">Nome do Produto</label>
            <input v-model="product.name" type="text" id="edit-name" class="form-control">
          </div>
          <div class="mb-3">
            <label for="edit-description" class="form-label">Descrição</label>
            <textarea v-model="product.description" id="edit-description" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label for="edit-price" class="form-label">Preço Unitário</label>
            <input v-model="product.price_unit" type="number" id="edit-price" class="form-control">
          </div>
          <div class="mb-3">
            <label for="edit-category" class="form-label">Categoria</label>
            <input v-model="product.category" type="text" id="edit-category" class="form-control">
          </div>
          <div class="mb-3">
            <label for="edit-supplier" class="form-label">Fornecedor</label>
            <select v-model="product.supplier" id="edit-supplier" class="form-control">
            <option disabled value="">Selecione um fornecedor</option>
            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
              {{ supplier.name }}
            </option>
          </select>
          </div>
          <div class="mb-3">
            <label for="edit-quantity" class="form-label">Quantidade em Estoque</label>
            <input v-model="product.quantity_stock" type="number" id="edit-quantity" class="form-control">
          </div>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
      </div>
    </div>
      </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        product: {
          code: '',
          name: '',
          description: '',
          price_unit: '',
          category: '',
          supplier: '',
          quantity_stock: '',
          tableKey: 0,
        },
        errors: {
          code: null,
          name: null,
          description: null,
          price_unit: null,
          category: null,
          supplier: null,
          quantity_stock: null,
        },
        isEditing: false,
        editingProductId: null,
        showCreateModal: false,
        products: [],
        suppliers: [],
      }
    },
    methods: {
      fetchProducts() {
        axios.get('/api/produtos')
          .then(response => {
            this.products = response.data;
          })
          .catch(error => {
            
          });
      },
      toggleCreateModal() {
      this.showCreateModal = !this.showCreateModal;
      if (this.showCreateModal) {
        this.resetProductForm();
      }
    },
    fetchSuppliers() {
      axios.get('/api/fornecedores')
        .then(response => {
          this.suppliers = response.data;
        })
        .catch(error => {
          // handle error
        });
    },
    resetProductForm() {
      this.product = {
        code: '',
        name: '',
        description: '',
        price_unit: '',
        category: '',
        supplier: '',
        quantity_stock: '',
        tableKey: 0,
      };
    },
      openModal() {
      this.isModalOpen = true;
      this.product = {
       id: product.id,
       code: product.code,
       name: product.name,
       description: product.description,
       price_unit: product.price_unit,
       category: product.category,
       supplier: product.supplier,
       quantity_stock: product.quantity_stock
      };
    },
    closeModal() {
      this.isModalOpen = false;
    },
    editProduct(id) {
      this.isEditing = true;
      this.editingProductId = id;
      axios.get(`/produtos/${id}/details`)
        .then(response => {
          this.product = response.data;
          this.fetchProducts();
        })
        .catch(error => {
          // handle error
        });
    },
    openEditModal(product) {
      this.isEditing = true;
      this.product = { ...product };
    },
    closeEditModal() {
      this.isEditing = false;
      this.product = {
        code: '',
        name: '',
        description: '',
        price_unit: '',
        category: '',
        supplier: '',
        quantity_stock: '',
      };
    },
    submitForm() {
      const productData = {
        ...this.product,
        supplier_id: this.product.supplier,
      };
      if (!this.product.supplier) {
        this.errors.supplier = 'Fornecedor é obrigatório';
        return;
      }
        if (this.isEditing) {
          axios.put(`/produtos/${this.editingProductId}`, productData)
            .then(response => {
              this.fetchProducts();
              this.closeEditModal();
            })
            .catch(error => {
              // handle error
            });
        } else {
          axios.post('/produtos/create', productData)
            .then(response => {
              this.fetchProducts();
              this.tableKey++;
            })
            .catch(error => {
              // handle error
            });
        }
      },
  
      deleteProduct(id) {
        axios.delete(`/produtos/${id}`)
          .then(response => {
            this.fetchProducts();
          })
          .catch(error => {
            
          });
      },
    },
    mounted() {
      this.fetchProducts();
      this.fetchSuppliers();
    }
  }
  
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
  ```