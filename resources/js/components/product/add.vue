 <template>
    <div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link to="/product">All Product</router-link>
          </li>
          <li class="breadcrumb-item active">Add Product</li>
        </ol>
        <!-- Icon Cards-->
       <div class="card shadow mb-4">
            <div class="card-header py-3">
				<span class="m-0 font-weight-bold text-primary">
					<i class="fas fa-chart-area"></i>
            		Product Insert 
				</span>
            <router-link to="/product" class="btn btn-sm btn-info" id="add_new"> All Product</router-link>
          </div>
          <div class="card-body">
          	  <form @submit.prevent="productInsert" enctype="multipart/form-data">
                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="productName">Product Name</label><span class="text-danger">*</span>
	                  <input type="text" v-model="form.name" class="form-control"  >
	                  <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="code">Code</label>
	                  <input type="text" v-model="form.code" class="form-control" >
	                  <small class="text-danger" v-if="errors.code">{{ errors.code[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
	          <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="root">Root</label>
	                  <input type="text" v-model="form.root" class="form-control" >
	                  <small class="text-danger" v-if="errors.root">{{ errors.root[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="quantity">Quantity</label><span class="text-danger">*</span>
	                  <input type="number" v-model="form.quantity" class="form-control" >
	                  <small class="text-danger" v-if="errors.quantity">{{ errors.quantity[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
	          <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="category">Category</label><span class="text-danger">*</span>
	                  	<select class="form-control" id="exampleFormControlSelect1" v-model="form.category_id">
							<option selected disabled>Select a Category</option>
							<option :value="category.id" v-for="category in categories" :key="category.id">{{ category.name }}</option>
						</select>
	                  <small class="text-danger" v-if="errors.category_id">{{ errors.category_id[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="quantity">Supplier</label><span class="text-danger">*</span>
					    <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id">
							<option selected disabled>Select a Supplier</option>
					      	<option :value="supplier.id" v-for="supplier in suppliers" :key="supplier.id">{{ supplier.name }}</option>
					    </select>
	                  <small class="text-danger" v-if="errors.quantity">{{ errors.quantity[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
	          <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-4 col-sm-12">
	                <div class="form-label-group">
	                  <label for="buyingPrice">Buying Price </label><span class="text-danger">*</span>
	                  <input type="number" v-model="form.buying_price" class="form-control"  autofocus="autofocus" >
	                  <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-4 col-sm-12">
	                <div class="form-label-group">
	                  <label for="sellingPrice">Selling Price</label><span class="text-danger">*</span>
	                  <input type="number" v-model="form.selling_price" class="form-control"  >
	                  <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-4 col-sm-12">
	                <div class="form-label-group">
	                  <label for="buyingDate">Buying Date</label><span class="text-danger">*</span>
	                  <input type="date" v-model="form.buying_date" class="form-control" >
	                  <small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
               <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
					<label for="photo">Photo</label><br>
	                 <input type="file" class="btn btn-info btn-sm" accept="image/*" @change="onFileSelected" >
	                  <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
	                </div>
	               </div>
	                <div class="col-md-6 col-sm-12">
	                	<img :src="form.photo" style="height: 70px; width: auto; border: 2px solid #D1D3E2;" >
	                </div>
	             </div>
	          </div>

               <button type="submit" class="btn btn-success">Submit</button>
              </form>
          </div>
          <br>
         </div>
       </div>
   </div>
</template>

<script type="text/javascript">
 export default { 
   created(){
     if(!User.loggedIn()){
       this.$router.push({ name: '/' })
     }else{

		axios.get('/api/category/')
        .then(({data}) => {
            this.categories = data
        })

		 axios.get('/api/supplier/')
        .then(({data}) => {
            this.suppliers = data
        })

	 }

   },
  data(){
    return{
      form:{
        name :'',
        code :'',
        root:'',
        category_id:'',
        supplier_id :'',
        photo:'',
        quantity : '',
        buying_price : '',
        selling_price : '',
        buying_date:''
    },
      errors:{},
	  categories:'',
	  suppliers:''

    }
  },

  methods:{

	productInsert(){
        axios.post('/api/product/',this.form)
        .then(() => {
            this.$router.push({ name: 'product' })
            Toast.fire({
                icon: 'success',
                title: 'Product Added Successfully!'
            })
        })
       .catch(error => {
        this.errors = error.response.data.errors

        Toast.fire({
          icon: 'error',
          title: 'Invalid Credentials !!'
        })

      })

    },

	onFileSelected(event){
		let file = event.target.files[0]
		if(file.size > 1048576 ){
			Toast.fire({
				icon: 'error',
				title: 'Image size have to less then 1MB'
			})

		}else{
			let reader = new FileReader();
			reader.onload = event => {
				this.form.photo = event.target.result
			}
			reader.readAsDataURL(file)
			
		}

	}


  }


}
</script>

<style type="text/css">

	#add_new{
	float: right;
}

</style>