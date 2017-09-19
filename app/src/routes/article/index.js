import { h, Component } from 'preact';
import style from './style';

export default class Article extends Component {

    constructor(host) {
        super();
        this.state = {
            article: {}
        };
        // Fetching article from api
        this.fetchArticleBySlug(host.slug);
    }

    fetchArticleBySlug(slug) {
        fetch('http://localhost:8888/api/articles/' + slug).then((response) => {
            const contentType = response.headers.get("content-type");
            if(contentType && contentType.indexOf("application/json") !== -1) {
                return response.json().then((json) => {
                    this.setState({article: json});
                }, this);
            } else {
                console.log("Oops, not JSON!");
            }
        });
    }

	render({}, {article}) {
		return (
			<div>
				<h2>{article.title}</h2>
				<p>{article.content}</p>
			</div>
		);
	}
}
