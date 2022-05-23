<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">Today's Orders</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">Today's Order List</span>
              <a :href=" '/api/today-orders-pdf/'" target="_blank" v-if="filterSearch != '' "  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="add_new"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
            </div>
            <div class="card-body">
              <input type="text" v-model="formItem" class="form-control col-md-4 col-sm-12" placeholder="Search Customer Name,Email,Phone,Address" ><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Id</th>
                      <th>Name</th>
                      <th>Total Amount</th>
                      <th>Pay</th>
                      <th>Due</th>
                      <th>Date</th>
                      <th>PayBy</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th>Id</th>
                      <th>Name</th>
                      <th>Total Amount</th>
                      <th>Pay</th>
                      <th>Due</th>
                      <th>Date</th>
                      <th>PayBy</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody v-if="filterSearch != '' ">
                    <tr v-for="order in filterSearch" :key="order.id" class="text-center">
                      <td>{{order.id}}</td>
                      <td>{{order.customer.name}}</td>
                      <td>{{ order.total }}</td>
                      <td>{{ order.pay }}</td>
                      <td>{{ order.due }}</td>
                      <td>{{ order.order_date }}</td>
                      <td>{{ order.payby }}</td>
                      <td>
                        <router-link :to="{name: 'view-order', params:{id: order.id} }" style="padding-right:8px" title="View"><i class="fa fa-eye text-success"></i></router-link>
                        <a :href=" '/api/invoice/'+order.id" title="Download Invoice" style="cursor: pointer; padding-right:8px"><i class="fa fa-download text-primary"></i></a>
                        <a @click="deleteOrder(order.id)" title="Delete" style="cursor: pointer"><i class="fa fa-trash text-danger"></i></a>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                        <td colspan="8" class="text-center">
                            <br><h1>No data found!</h1><br>
                        </td>
                    </tr>
                  </tbody>
                </table>
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
              this.allOrder()
            }
      },

      data(){
          return{
            orders:[],
            formItem:'',         
          }
      },

      computed:{
          filterSearch(){
            return this.orders.filter( order =>{
                      return order.customer['name'].toLowerCase().match( this.formItem.toLowerCase() ) ||
                            order.customer['email'].toLowerCase().match( this.formItem.toLowerCase() ) ||
                            order.customer['phone'].match( this.formItem ) ||
                            order.customer['address'].match( this.formItem ) 
                      })
          },
  
      },

      methods:{
        allOrder(){
          axios.get('/api/today-order')
                .then( ({data}) => {
                    this.orders = data 
                })
                .catch(error => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong!'
                    })

                })
        },
        deleteOrder(id){
              Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                axios.post('/api/order-delete/'+id)
                .then(()=>{
                  this.orders = this.orders.filter(order =>{
                      return order.id !=id
                  })

                  Toast.fire({
                    icon: 'success',
                    title: 'Order Delete Successfully!'
                  })
                  
                })
                .catch(()=>{
                  this.$router.push({name: 'today-order'})
                })
              }
            })
          },

      }

  }
</script>



<style type="text/css">
	
  #imgstyle{
    height: 50px;
    border: 1px solid rgb(209 211 225);
    border-radius: 50%;
  }
  .dataTables_empty{
    display: none;
  }

</style>