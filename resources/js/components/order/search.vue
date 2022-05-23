<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">Search Order</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">Search Order</span>

              <a :href="'/api/order-by-month-pdf/'+orderMonth " target="_blank" class="btn btn-sm btn-primary" id="add_new" v-if="orderMonth != '' && orderYear == '' && orderDate == '' && filterSearch != '' "> Generate PDF</a>
              <a :href="'/api/order-by-year-pdf/'+orderYear " target="_blank" class="btn btn-sm btn-primary" id="add_new" v-else-if="orderYear != '' && orderMonth == '' && orderDate == '' && filterSearch != '' "> Generate PDF</a>
              <a :href="'/api/order-by-month-year-pdf/'+orderMonth +'/'+orderYear " target="_blank" class="btn btn-sm btn-primary" id="add_new" v-else-if="orderYear != '' && orderMonth != '' && orderDate == '' && filterSearch != '' "> Generate PDF</a>
              <a :href="'/api/order-by-date-pdf/'+orderDate " target="_blank" class="btn btn-sm btn-primary" id="add_new" v-else-if="orderDate != '' && orderYear == '' && orderMonth == '' && filterSearch != '' "> Generate PDF</a>
              <router-link to="/today-order" class="btn btn-sm btn-primary" id="add_new" v-else > Todays Order</router-link>
              
            </div>
            <div class="card-body">
              <div class="row">
              <input type="date" v-model="orderDate" class="form-control col-md-3 col-sm-12" ><br>
                <select v-model="orderMonth"   class="form-control col-md-2 col-sm-12" id="exampleFormControlSelect1">
                  <option value="">All Month</option>
                  <option :value="year.order_month" v-for="year in order_month" :key="year.order_month">{{year.order_month}}</option>
                </select>
                <select v-model="orderYear"   class="form-control col-md-2 col-sm-12" id="exampleFormControlSelect1">
                  <option value="">All Year</option>
                  <option :value="year.order_year" v-for="year in order_year" :key="year.order_year">{{year.order_year}}</option>
                </select>
              </div>
              <br>
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
                        <a :href=" '/api/invoice/'+order.id" title="Download Invoice" style="cursor: pointer"><i class="fa fa-download text-primary"></i></a>
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
              order_month:[],
              order_year:[],
              formItem:'',
              orderDate:'',
              orderMonth:'',
              orderYear:'',
          }
      },

      computed:{
          filterSearch(){
            return this.orders.filter( order =>{
                    
                    if(this.orderDate && !(this.orderYear) && !(this.orderMonth) ){
                      return order.created_at.match(this.orderDate) 

                    }else if(this.orderMonth && !(this.orderYear)  ){
                        this.orderDate = ''
                      return order.order_month.match(this.orderMonth) 
                    
                    }else if( this.orderYear && this.orderMonth  ){
                        this.orderDate = ''
                        return order.order_month.match(this.orderMonth) &&
                                order.order_year.match(this.orderYear)

                    }else if(this.orderYear && !(this.orderMonth)  ){
                        this.orderDate = ''
                        return  order.order_year.match(this.orderYear)
                    }


                })
          },
  
      },

      methods:{
        allOrder(){
          axios.get('/api/all-order')
          .then( ({data}) => {
              this.orders = data[0]
              this.order_month = data[1]
              this.order_year = data[2]
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
	
  .dataTables_empty{
    display: none;
  }

</style>