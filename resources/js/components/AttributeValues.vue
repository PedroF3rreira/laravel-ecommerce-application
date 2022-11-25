<template>
	<div id="">
    <div class="tile">
        <h3 class="tile-title">Option Values</h3>
        <div class="tile-body">
            <div class="tile">
                <h3 class="tile-title">Attribute Values</h3>
                <hr>
                <div class="tile-body">
                    <div class="form-group">
                        <label class="control-label" for="value">Value</label>
                        <input
                        class="form-control"
                        type="text"
                        placeholder="Enter attribute value"
                        id="value"
                        name="value"
                        v-model="value"
                        />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="price">Price</label>
                        <input
                        class="form-control"
                        type="number"
                        placeholder="Enter attribute value price"
                        id="price"
                        name="price"
                        v-model="price"
                        />
                    </div>
                </div>
                <div class="tile-footer">
                    <div class="row d-print-none mt-2">
                        <div class="col-12 text-right">
                            <div class="spinner-grow text-success " v-if="buttonLoad">

                            </div>
                            <button class="btn btn-success" type="submit" @click.stop="saveValue()" v-if="addValue">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            </button>
                            <button class="btn btn-success" type="submit" @click.stop="updateValue()" v-if="!addValue">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>Update
                            </button>
                            <button class="btn btn-primary" type="submit" @click.stop="reset()" v-if="!addValue">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>Reset
                            </button>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div class="d-flex align-items-center col">
                    <div class="spinner-grow text-success " v-if="load">
                    
                    </div>    
                </div>
                
                <table class="table table-sm" v-if="!load">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Value</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="value in values">
                        <td style="width: 25%" class="text-center">{{ value.id}}</td>
                        <td style="width: 25%" class="text-center">{{ value.value}}</td>
                        <td style="width: 25%" class="text-center">{{ value.price}}</td>
                        <td style="width: 25%" class="text-center">
                            <button class="btn btn-sm btn-primary" @click.stop="editAttributeValue(value)">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click.stop="deleteValue(value)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
</template>
<script>
	export default {
		name: 'attribute-values',
		props: ['attributeid'],
		data(){
			return{
				values: [],
				value: '',
				price: '',
				currentId: '',
				addValue: true,
				key: 0,
                load: false,
                buttonLoad: false,
			}
		},
		created: function() {
			this.loadValues();
		},
		methods: {
			loadValues() {
                
                let attributeId = this.attributeid;
                
                let _this = this;
                
                this.load = true;
                
                axios.post('/admin/atributos/get-values', {
                    id: attributeId
                
                }).then (function(response){
                    
                    _this.values = response.data;
                    _this.load = false;
                
                }).catch(function (error) {
                    console.log(error);
                });
		    },
            saveValue() {
                if(this.value === ''){
                    this.$swal("opss","o valor do atributo é obrigatório.",'warning');
                }else{

                    let attributeId = this.attributeid;
                    let _this = this;
                    
                    this.buttonLoad = true;

                    axios.post('/admin/atributos/add-values', {
                        id: attributeId,
                        value: _this.value,
                        price: _this.price

                    }).then(function(response){
                        
                        _this.values.push(response.data);
                        _this.resetValue();
                        _this.buttonLoad = false;
                        _this.$swal("exito!","Valor de atibuto adicionada com sucesso","success");

                    }).catch(function(error){
                        console.log(error);
                    });
            }

            },
            editAttributeValue(value){
                this.addValue = false;
                this.value = value.value;
                this.price = value.price;
                this.currentId = value.id;
                this.key = this.value.indexOf(value);
                
            },
            updateValue() {
                if (this.value === '') {
                   
                    this.$swal("Error, Value for attribute is required.", 'warning');

                } else {
                    
                    let attributeId = this.attributeid;
                    let _this = this;
                    
                    axios.post('/admin/atributos/update-values', {
                        
                        id: attributeId,
                        value: _this.value,
                        price: _this.price,
                        valueId: _this.currentId

                    }).then (function(response){
                        
                        _this.values.splice(_this.key, 1);
                        _this.resetValue();
                        _this.values.push(response.data);
                        _this.$swal("Success!","valor de atributo atualizado", 'success');

                    }).catch(function (error) {
                        _this.$swal("Erro", "Ocorreu um erro entre em contato com o suporte!", 'error')
                        console.log(error);
                    });
                }
            },
            deleteValue(value){
                
                this.currentId = value.id;

                this.key = this.values.indexOf(value);
                
                let _this = this;

                axios.post('/admin/atributos/delete-values', {
                    id: _this.currentId
                }).then (function(response){
                    if (response.data.status === 'success') {
                        _this.values.splice(_this.key, 1);
                        _this.resetValue();
                        _this.$swal("Success! opção de valor de atrubito foi deletado!", "success");
                    } else {
                        _this.$swal("Não foi possivel deletar!");
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            resetValue(){
                this.value = '',
                this.price = ''
            },
            reset(){
                this.addValue = true,
                this.resetValue();
            }
	}
}
</script>