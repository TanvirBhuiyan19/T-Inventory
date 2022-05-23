<template>
	  <div>
     <!-- Begin Page Content   -->
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <!-- <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">All Product</li>
        </ol> -->
          <!-- DataTales Example -->
        
        <div class="row">
            <div class="col-md-5 col-lg-5 col-sm-12" style="padding: 0px;">
              <div class="card shadow mb-4">
                  <div class="card-header py-2">
                    <span class="m-0 font-weight-bold text-primary">
                      <i class="fas fa-shopping-cart"></i>
                      Cart List
                      </span>
                      <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal" id="add_new"> Add Customer</button>
                  </div>

                  <div class="card-body">
                      <table class="table table-sm table-striped" style="width: 105%; margin-left: -10px;">
                        <thead>
                          <tr class="text-center">
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">L.Total</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody v-if="carts != '' ">
                          <tr v-for="cart in carts" :key="cart.id">
                            <td>{{ cart.product_name }}</td>
                            <td>{{ cart.product_price }}</td>
                            <td>
                              <button class="btn btn-sm btn-danger" style="border: 1px solid grey" v-if="cart.product_qty > 1" @click.prevent="decrement(cart.id)"><strong>-</strong></button>
                              <button class="btn btn-sm btn-danger" style="border: 1px solid grey" v-else disabled ><strong>-</strong></button>
                              <button class="btn btn-sm" style="border: 1px solid grey; margin:-5px;" disabled ><strong style="color: red">{{cart.product_qty}}</strong></button> 
                              <button class="btn btn-sm btn-success" style="border: 1px solid grey"  @click.prevent="increment(cart.id)" ><strong>+</strong></button>                                
                            </td>
                            <td>{{ cart.sub_total }}</td>
                            <td class="text-center">
                              <a @click.prevent="removeItem(cart.id)" title="Remove" style="cursor: pointer"><i class="fa fa-times text-danger"></i></a>                              
                              </td>
                          </tr>
                        </tbody>
                        <tbody v-else>
                            <td colspan="5" class="text-center">
                              <h1 style="margin-top: 50px">Cart is empty!!</h1>
                              <p>Please add some product.</p>
                            </td>
                        </tbody>
                      </table>
                  </div>

                  <div class="card-footer">
                      <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                         Total Quantity:
                          <strong>{{ qty}}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                         Sub Total:
                          <strong>{{subTotal}} Tk</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          Vat:
                         <strong> {{this.vat}} % </strong>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center text-success">
                          Total:
                         <strong class="text-success"> {{ (subTotal * this.vat/100) + subTotal}} Tk</strong>
                        </li>
                      </ul>
                      <br>

                      <form @submit.prevent="orderDone">
                      <label>Customer Name</label><span class="text-danger">*</span>
                      <select class="form-control" v-model="customer_id">
                        <option :value="customer.id" v-for="customer in customers" :key="customer.id" style="height: 100px">{{ customer.name }} ({{ customer.phone }})</option>
                      </select>
                      <small class="text-danger" v-if="errors.customer_id">{{ errors.customer_id[0] }}</small><br/>

                      <label>Pay</label><span class="text-danger">*</span>
                      <input type="number" class="form-control"  v-model="pay">
                      <small class="text-danger" v-if="errors.pay">{{ errors.pay[0] }}</small><br/>

                      <label>Due</label>
                      <p class="form-control">{{ (subTotal*this.vat/100 + subTotal) - this.pay }}</p>

                      <label>Pay By </label><span class="text-danger">*</span>
                      <select class="form-control" v-model="payby">
                         <option value="HandCash">Hand Cash</option>
                         <option value="Cheaque">Cheaque</option>
                         <option value="GiftCard">Gift Card</option>
                      </select>
                      <small class="text-danger" v-if="errors.payby">{{ errors.payby[0] }}<br/></small>

                      <br>
                      <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </form>
                <br><br><br><br>
                  </div>
                

              </div>
            </div>


          <!--====================================== Customer Modal==================================== -->
          <!--customer add modal--> 
             <!-- Modal -->
             <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
               <div class="modal-dialog" role="document">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">New Customer</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <div class="modal-body">  
                      <form @submit.prevent="customerInsert" enctype="multipart/form-data">
                          <div class="form-group">
                            <div class="form-row">
                              <div class="col-md-6 col-sm-12">
                                <div class="form-label-group">
                                  <label for="fullName">Full Name</label><span class="text-danger">*</span>
                                  <input type="text" v-model="form.name" class="form-control"  >
                                  <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-12">
                                <div class="form-label-group">
                                  <label for="email">Email Address</label>
                                  <input type="email" v-model="form.email" class="form-control" >
                                  <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-6 col-sm-12">
                                  <div class="form-label-group">
                                  <label for="phone">Phone Number</label><span class="text-danger">*</span>
                                  <input type="text" v-model="form.phone" class="form-control" >
                                  <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                  </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                  <div class="form-label-group">
                                    <label for="address">Address</label><span class="text-danger">*</span>
                                    <input type="text" v-model="form.address" class="form-control" >
                                    <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-8 col-sm-12">
                                  <div class="form-label-group">
                                    <label for="photo">Photo</label><br>
                                    <input type="file" class="btn btn-info btn-sm" accept="image/*" @change="onFileSelected" >
                                    <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <img :src="form.photo" style="height: 70px; width: auto; border: 2px solid #D1D3E2;" >
                                </div>
                              </div>
                          </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                      </form>
                   </div>
                 </div>
               </div>
             </div>
             <!--end customer modal-->
          <!--====================================== End: Customer Modal==================================== -->


            <div class="col-md-7 col-lg-7 col-sm-12">
              <div class="card shadow mb-4">
                <div class="card-header py-2">
                  <span class="m-0 font-weight-bold text-primary">Products</span>
                </div>
                <div class="card-body">
                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true" style="padding:5px; margin:5px;">All product</a>
                    </li>

                    <li class="nav-item" v-for="category in categories" :key="category.id">
                      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true" @click="categoryProduct(category.id)" style="padding:5px; margin:5px;">
                          {{ category.name }}
                      </a>
                    </li>

                  </ul>
                  <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                      <input type="text" v-model="formItem" class="form-control" placeholder="Search Product Name,Code"><br>
                        <div class="row">
                          <div class="col-lg-3 col-md-4 col-sm-6 col-6" v-for="product in filterSearch" :key="product.id">
                          <button class="btn btn-sm" style="padding:0px; margin:0px; margin-bottom:8px;"  @click.prevent="AddToCart(product.id)">
                            <div class="card m-auto">
                              <img :src="'/backend/uploads/product/' + product.photo" class="card-img-top m-auto" style="height: auto; width: 100%;">
                              <div class="card-body" style="padding: 5px !important">
                                <small class="card-title" style="line-height: 1.3 !important">{{ product.name }}</small><br>
                                <span class="badge badge-success" v-if="product.quantity >= 1"> Availble ({{ product.quantity }}) </span>
                                <span class="badge badge-danger" v-else >Stock Out</span>
                              </div>
                            </div>
                            </button>

                          </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"> 
                      <input type="text" v-model="categorySearchItem" class="form-control" placeholder="Search Product Name,Code"><br>
                        <div class="row">
                          <div class="col-lg-3 col-md-4 col-sm-6 col-6" v-for="product in filterCategorySearch" :key="product.id">
                          <button class="btn btn-sm" style="padding:0px; margin:0px; margin-bottom:8px;"  @click.prevent="AddToCart(product.id)">
                            <div class="card m-auto">
                              <img :src="'/backend/uploads/product/' + product.photo" class="card-img-top m-auto" style="height: auto; width: 100%;">
                              <div class="card-body" style="padding: 5px !important">
                                <small class="card-title" style="line-height: 1.3 !important">{{ product.name }}</small><br>
                                <span class="badge badge-success" v-if="product.quantity >= 1"> Availble ({{ product.quantity }}) </span>
                                <span class="badge badge-danger" v-else >Stock Out</span>
                              </div>
                            </div>
                            </button>

                          </div>
                        </div>
                    </div>

                  </div>

                </div>
            <br><br>
              </div>
            </div>
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
              this.allProduct(),
              this.allCategory(),
              this.cartProduct(),
              this.getCustomers(),
              this.getVat(),
              Reload.$on('AfterAdd', ()=>{
                this.cartProduct(),
                this.getCustomers()
              })
            }
      },

      data(){
          return{
              form:{
                  name :'',
                  email :'',
                  address:'',
                  photo :'',
                  phone:'',
              },
              carts:[],
              products:[],
              categoryProducts:[],
              formItem:'',
              categorySearchItem:'',
              categories:{},
              customers:{},
              errors:{},
              customer_id:'',
              pay:'',
              payby:'',
              vat:'',
          }
      },

      computed:{
          filterSearch(){
            return this.products.filter( product =>{
                  return product.name.toLowerCase().match(this.formItem.toLowerCase()) || 
                        product.code.toLowerCase().match(this.formItem.toLowerCase()) 
                  })
          },
          filterCategorySearch(){
            return this.categoryProducts.filter( product =>{
                  return product.name.toLowerCase().match(this.categorySearchItem.toLowerCase()) || 
                        product.code.toLowerCase().match(this.categorySearchItem.toLowerCase()) 
                  })
          },
          qty(){
           let sum=0;
           for(let i =0; i < this.carts.length; i++ ){
              sum += (parseFloat(this.carts[i].product_qty));
           }
           return sum;
         },
          subTotal(){
           let sum=0;
           for(let i =0; i < this.carts.length; i++ ){
              sum += (parseFloat(this.carts[i].sub_total));
           }
           return sum;
         },
          subTotalProfit(){
           let sum=0;
           for(let i =0; i < this.carts.length; i++ ){
              sum += (parseFloat(this.carts[i].profit));
           }
           return sum;
         },
  
      },

      methods:{
        allProduct(){
          axios.get('/api/product')
          .then( ({data}) => {
              this.products = data 
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        allCategory(){
            axios.get('/api/category')
            .then(({data}) => {
                this.categories = data 
            })
          },
        categoryProduct(id){
            axios.get('/api/category-product/'+id)
            .then(({data}) => {
                this.categoryProducts = data 
            })
        },
        customerInsert(){
            axios.post('/api/customer/',this.form)
            .then(() => {
                $('#closeModal').click();
                    this.form.name= '', 
                    this.form.email= '', 
                    this.form.address= '', 
                    this.form.phone= '', 
                Toast.fire({
                  icon: 'success',
                    title: 'Customer Added Successfully!'
                })
                  Reload.$emit('AfterAdd')
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
        },
        AddToCart(product_id){
            axios.get('/api/add-cart/'+product_id)
              .then(() => {
                Toast.fire({
                  icon: 'success',
                      title: 'Product Added to Cart!'
                  })
                  Reload.$emit('AfterAdd')
            })
            .catch(() =>  {
                Toast.fire({
                  icon: 'error',
                  title: 'Out of Stock !!'
                })
            })
        },
        increment(id){
            axios.get('/api/increment-cart/'+id)
              .then(() => {
                Toast.fire({
                  icon: 'success',
                      title: 'Cart Increment !'
                  })
                  Reload.$emit('AfterAdd')
            })
            .catch(() =>  {
                Toast.fire({
                  icon: 'error',
                  title: 'Out of Stock !!'
                })
            })
        },
        decrement(id){
            axios.get('/api/decrement-cart/'+id)
              .then(() => {
                Toast.fire({
                  icon: 'success',
                      title: 'Cart Decrement !'
                  })
                  Reload.$emit('AfterAdd')
            })
            .catch(() =>  {
                Toast.fire({
                  icon: 'error',
                  title: 'Quantity can not less then 1 !!'
                })
            })
        },
        cartProduct(){
            axios.get('/api/cart')
              .then(({data}) => {
                  this.carts = data
            })
        },
        removeItem(id){
            axios.get('/api/remove-cart/'+id)
            .then(() => {
                this.carts = this.carts.filter(cart =>{
                    return cart.id !=id
                  })
                Toast.fire({
                  icon: 'success',
                      title: 'Product Remove from Cart!'
                  })
            })
        },
        getCustomers(){
            axios.get('/api/customer')
              .then(({data}) => {
                  this.customers = data
            })
        },
        getVat(){
              axios.get('/api/settings/')
                .then( ({data}) => {
                    this.vat = data.vat
                })
        },
        orderDone(){
            let Total = this.subTotal*this.vat/100 + this.subTotal;
            let due = (this.subTotal*this.vat/100 + this.subTotal) - this.pay;
            let data = {qty:this.qty, due:due, vat:this.vat, sub_total:this.subTotal, total:Total, 
                        customer_id:this.customer_id, pay:this.pay, profit:this.subTotalProfit, payby:this.payby}

            if(Total > 0){
                  axios.post('/api/order/',data)
                  .then(() => {
                      Toast.fire({
                        icon: 'success',
                          title: 'Order Place Successfully!'
                      })
                      this.$router.push({ name: 'home' })
                  })
                  .catch(error => {
                  this.errors = error.response.data.errors
                  Toast.fire({
                    icon: 'error',
                    title: 'Invalid Credentials !!'
                  })
                })
            }else{
                  Toast.fire({
                    icon: 'error',
                    title: 'Empty Cart! Please add some product'
                  })
            }
            

        },
        

      }

  }
</script>



<style type="text/css">
	
  #imgstyle{
    height: 50px;
    border: 1px solid rgb(209 211 225);
    border-radius: 10%;
  }
  .dataTables_empty{
    display: none;
  }

</style>