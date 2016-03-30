class ChangeNotes < ActiveRecord::Migration
  def change
    remove_column :offers, :offer_note
    add_column :offers, :grNotes, :text
    add_column :offers, :dpNotes, :text
  end
end
