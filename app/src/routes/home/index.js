import { h, Component } from 'preact';
import style from './style';
import Article from "../article/index";
import ArticleBox from "../../components/ArticleBox";
import { Link } from 'preact-router/match';


export default class Home extends Component {

	constructor() {
        super();
        this.state = {
        	articles: []
		};
        // Fetching articles from api
        this.fetchArticles();
	}

	fetchArticles() {
		fetch('http://localhost:8888/api/articles').then((response) => {
            const contentType = response.headers.get("content-type");
            if(contentType && contentType.indexOf("application/json") !== -1) {
                return response.json().then((json) => {
                    this.setState({articles: json});
                }, this);
            } else {
                console.log("Oops, not JSON!");
            }
		});
	}

	render({}, {articles}) {
		return (
			<div class="flex-container">
				<aside class="mod w20 pam aside">
					<nav id="navigation" role="navigation">
						<ul class="pam">
							{articles.map(({slug, title}) => <Link href={'/article/' + slug}><li class="pam inbl">{title}</li></Link>)}
						</ul>
					</nav>
					<p>Lorem Salu bissame ! Wie geht's les samis ? Hans apporte moi une Wurschtsalad avec un picon bitte, s'il te plaît. Voss ? Une Carola et du Melfor ? Yo dû, espèce de Knäckes, ch'ai dit un picon !</p>
				</aside>
				<main id="main" role="main" class="flex-item-fluid pam">
                    {
						articles.map(article => <Link href={'/article/' + article.slug}><ArticleBox article={article} /></Link>)
                    }
				</main>
				<aside class="mod w20 pam aside">
					<p>Lorem Salu bissame ! Wie geht's les samis ? Hans apporte moi une Wurschtsalad avec un picon bitte, s'il te plaît. Voss ? Une Carola et du Melfor ? Yo dû, espèce de Knäckes, ch'ai dit un picon !</p>
				</aside>
		</div>
		);
	}
}
