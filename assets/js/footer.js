let footer = {
	template: `
      	<footer class="w-100 bg-dark p-3 sticky-bottom" style="bottom: 0">
      		<p class="text-center yellow-text" v-html="footer"></p>
      	</footer>
	`,
	data(){
		return{
			footer:'<i class="fa fa-code yellow-text"></i> with <i class="fa fa-heart pink-text"></i> by CodeState | Copyright &copy; 2018'
		}
	}
}

export {footer}