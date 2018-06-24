<template>
	<ul class="tree-menu list-unstyled">
		<li :class="liClass" :style="liStyle">
			<a :href="getPageUrl()" style="text-decoration: none" :style="checkCurrentPage()">{{ title }}</a>
		</li>

		<sidebar-tree 
			v-for="child in children"
			:key="child.id"
			:courseSlug="courseSlug"
			:pageSlug="child.slug"
			:currentPage="currentPage"
			:title="child.title"
			:children="child.children"
			:depth="depth + 1"
		></sidebar-tree>
	</ul>
</template>
<script>
export default {
	props: ['courseSlug', 'pageSlug', 'currentPage', 'title',  'children', 'depth'],
	data() {
		return {
            liClass: {},
			liStyle: {
				'padding-left': this.depth * 20 + 'px',
			},
		};
	},
	created() {
		if (this.depth == 0) {
            this.liClass['h6 mt-3'] = true;
		}
	},
	methods: {
		getPageUrl() {
			return '/courses/' + this.courseSlug + '/pages/' + this.pageSlug;
		},
		checkCurrentPage() {
			if (this.currentPage == this.title) {
				return {
                    color: '#007bff',
                }
			} else {
				return {
                    color: '#555',
                }
			}
		},
	},
}
</script>