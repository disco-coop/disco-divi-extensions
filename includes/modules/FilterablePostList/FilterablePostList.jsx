// External Dependencies
import React, {Component, Fragment} from 'react';

// Internal Dependencies
import './style.css';

class FilterablePostList extends Component {

  static slug = 'filterable_post_list';

  render() {
    const number_of_posts = this.props.number_of_posts;
    const columns = this.props.columns;

    return (
      <Fragment>
        <a href="/">
          <div className="overlay">
            <div className="title">
            <span className="text">
              Show {number_of_posts} posts filterable by category in {columns} columns.
            </span>
            </div>
          </div>
        </a>
      </Fragment>
    );
  }
}

export default FilterablePostList;
