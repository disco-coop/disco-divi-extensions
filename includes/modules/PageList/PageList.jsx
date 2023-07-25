// External Dependencies
import React, {Component, Fragment} from 'react';

// Internal Dependencies
import './style.css';


class PageList extends Component {

  static slug = 'page_list';

  render() {
    const Parent = this.props.parent;
    const cnt = this.props.cnt;
    const columns = this.props.columns;

    return (
      <Fragment>
        <a href="/">
          <div className="overlay">
            <div className="title">
            <span className="text">
              Show {cnt} pages under {Parent} in {columns} columns
            </span>
            </div>
          </div>
        </a>
      </Fragment>
    );
  }
}

export default PageList;
