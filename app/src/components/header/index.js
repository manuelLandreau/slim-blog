import { h, Component } from 'preact';
import { Link } from 'preact-router/match';
import style from './style';

export default class Header extends Component {
	render() {
		return (
			<header>
				<header id="header" role="banner" class="pam">
					<nav>
						{/*{ articles().map(({slug, title}) => <Link href={'/article/' + slug}>{title}</Link>)}*/}
					</nav>
				</header>
			</header>
		);
	}
}
