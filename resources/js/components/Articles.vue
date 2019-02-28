<template>
   <div class="container-fluid mt-1 mb-3" style="max-width: 1400px;">
      <div class="page-header fluid bg-dark text-white p-3 my-3">
         <h1>Articles</h1>
      </div>

      <nav aria-label="Page navigation example">
         <ul class="pagination">
            <li 
               v-bind:class="[{disabled: pagination.pageCurrent <= 1 }]"  
               class="page-item"
            >
               <a class="page-link" href="#" @click="renderPrev">
                  <i class="fa fa-chevron-left"></i>  
               </a>
            </li>

            <li class="page-item disabled">
               <a href="#" class="page-link text-dark">
                Page {{pagination.pageCurrent}} of {{pagination.pageLimit + 1}}
               </a>
            </li>
            
            <li
               v-bind:class="[{disabled: (pagination.pageLimit + 1) === pagination.pageCurrent }]" 
               class="page-item"
            >
               <a class="page-link" href="#" @click="renderNext">
                  <i class="fa fa-chevron-right"></i>
               </a>
            </li>
         </ul>
      </nav>
      <div class="card-deck">
         
         <div v-for="article in articles" v-bind:key="article.source.url" class="card text-white bg-dark mb-4 shadow-lg" style="min-width: 240px;">
            <img v-bind:src="article.urlToImage" class="card-img-top" />
         
         
            <div class="card-header mb-5">
               <h4 class="card-title">{{ article.title }}</h4>
               <!-- <p class="card-text text-muted">{{ article.description }}</p> -->
               <small class="text-muted">
                  {{ article.author }}
               </small>
               <p class="card-text">
                  <small class="text-muted">
                     Published at {{ new Date(article.publishedAt).toLocaleString() }}
                  </small>
               </p>
            </div>
         
            <!-- <div class="card-body">
               <p class="card-text">{{ article.content }}</p>
            </div> -->
            <!-- <div class="card-footer" style="position:absolute; bottom:0; left:0; right:0;">
               
            </div> -->
         </div>
              
      </div>
   </div>
   
</template>


<script>
export default {
   data() {
      return {
         articles: [],
         article: {
            source: {
               id: ''
            },
            title: '',
            description: '',
            urlToImage: '',
            publishedAt: ''
         },
         article_id: '',
         pagination: {
            pageCurrent: 1,
            pageLimit: ''
         },
         edit: false

      }
   },

   created() {
      this.fetchArticles('business', 'ph', this.pagination.pageCurrent)
   },

   methods: {
      
      fetchArticles(category, country, pageNumber) {
         const key = '71fd058d659e4a12ba70c00b281932ca'  
         const limit = 11
         const page = pageNumber       
         let vm = this
         const query = `https://newsapi.org/v2/top-headlines?country=${country}&category=${category}&apiKey=${key}&pageSize=${limit}&page=${page}`
         fetch(query)
            .then(res => res.json())
            .then(res => {
               this.articles = res.articles
               this.pagination.pageLimit = Math.round(res.totalResults / limit)
               // console.log(this.pagination.pageCurrent)
               // console.log(this.pagination.pageLimit)
               // console.log(query)
               
            })
            .catch(err => console.log(err))
      },

      renderNext() {
         this.pagination.pageCurrent = this.pagination.pageCurrent + 1
         this.fetchArticles('business', 'ph', this.pagination.pageCurrent)
         // console.log('next')
      },

      renderPrev() {
         this.pagination.pageCurrent = this.pagination.pageCurrent - 1
         this.fetchArticles('business', 'ph', this.pagination.pageCurrent)
         // console.log('prev')
      },      

      deleteArticle(id){
         if(confirm('Are you sure? You can\'t undo this change.')) {
            fetch(`api/article/${id}`, {
               method: 'delete',
            })
            .then(res => res.json())
            .then(data => {
               alert('Article removed')
               this.fetchArticles()
            })
            .catch(err => console.log(err))
         }
      },

      editArticle(id){
         if(confirm('Are you sure? You can\'t undo this change.')) {
            fetch(`api/article/${id}`, {
               method: 'patch',
            })
            .then(res => res.json())
            .then(data => {
               alert('Article removed')
               this.fetchArticles()
            })
            .catch(err => console.log(err))
         }
      }
   }
}
</script>
