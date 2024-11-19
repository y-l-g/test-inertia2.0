import { Config } from "ziggy-js";

export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at?: string;
  permissions: string[];
  roles: string[];
}

export type PaginatedData<T = any> = {
  data: T[];
  links: Record<string, string>;
};

export type Comment = {
  id: number;
  comment: string;
  created_at: string;
  user: User;
};

export type Feature = {
  id: number;
  name: string;
  description: string;
  created_at: string;
  user: User;
  upvote_count: number;
  user_has_upvoted: boolean;
  user_has_downvoted: boolean;
  comments_count: number;
  comments: Comment[];
};

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>
> = T & {
  auth: {
    user: User;
  };
  ziggy: Config & { location: string };
};
