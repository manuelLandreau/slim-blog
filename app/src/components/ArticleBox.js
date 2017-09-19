
const ArticleBox = ({article}) => {
    return (
        <div>
            <h2>{article.title}</h2>
            <p>{article.description}</p>
        </div>
    )
};

export default ArticleBox;
